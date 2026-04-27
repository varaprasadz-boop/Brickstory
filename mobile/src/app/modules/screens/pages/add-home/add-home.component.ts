import { ChangeDetectorRef, Component, NgZone, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { ScrollDetail, ViewDidEnter } from '@ionic/angular';
import { ApiService } from 'src/app/core/services/api/http.service';
import { addHome } from 'src/app/core/services/api/models/api-payload.model';
import {
  DropdownParams,
  ParamsData,
} from 'src/app/core/services/api/models/api-response.model';
import { Camera, CameraResultType, CameraSource } from '@capacitor/camera';
import { ActionSheetController } from '@ionic/angular';
import { AlertService } from 'src/app/core/services/alert/alert.service';
import { ModalController } from '@ionic/angular';
import { AutoCompletePage } from './components/auto-complete.page';
import { SimilarHouseModalComponent } from './components/similar-house-modal.component';
import { AddStoryComponent } from 'src/app/shared/components/add-story/add-story.component';

declare var google: any;

@Component({
  selector: 'app-add-home',
  templateUrl: './add-home.component.html',
  styleUrls: ['./add-home.component.scss'],
})
export class AddHomeComponent implements OnInit {
  public params!: ParamsData;
  public formSubmitted: boolean = false;
  public ischecked: boolean = false;
  public lived_here: boolean = false;
  public isNoChecked: boolean = false;
  public imageData: string = '';
  public url: string = '';
  public isSubmitShown: boolean = true;
  public selectedStateObject: any = null;
  public selected: any = {
    value: '',
    key: '',
  };
  /** Inline address autocomplete (no map modal) */
  public addressSuggestions: string[] = [];
  public showAddressDropdown = false;
  private addressSearchTimeout: any;

  public inputs: addHome = {
    user_id: 0,
    address1: '',
    city: '',
    owner_name: '',
    architech: '',
    square_feet: '',
    address2: '',
    state: '',
    zip: '',
    home_profile_photo: '',
    year_built: '',
    house_style_id: '',
    bedroom_id: '',
    material_id: '',
    from_date: '00',
    to_date: '00',
    image_source: '',
  };

  public constructor(
    private modalCtrl: ModalController,
    private api: ApiService,
    private route: ActivatedRoute,
    private actionSheetController: ActionSheetController,
    private cdr: ChangeDetectorRef,
    private router: Router,
    public alert: AlertService,
    private zone: NgZone
  ) {
    let user: any = localStorage.getItem('userData');
    user = JSON.parse(user);
    this.inputs.user_id = user.id;
  }
  public ngOnInit(): void {
    this.route.data.subscribe((response: any) => {
      this.params = response.data;
    });
  }
  public handleScroll(ev: CustomEvent<ScrollDetail>): void {
    this.isSubmitShown = ev.detail.scrollTop > 200 ? false : true;
  }
  public isFormInvalid(): boolean {
    return (
      !this.inputs.address1 ||
      !this.inputs.city ||
      !this.inputs.state ||
      !this.inputs.year_built
    );
  }
  public checkSimilarHouse(): void {
    if (!this.inputs.address1) {
      this.alert.presentAlert(
        'Missing Fields',
        '',
        'Please enter address to check similar houses.',
        [
          {
            text: 'Ok',
            role: 'confirm',
          },
        ]
      );
      return;
    }
    this.api.similarHouse(this.inputs.address1).subscribe((data) => {
      if (data.status === 'success') {
        if (data.data.count > 0) {
        }
      } else {
        this.alert.presentAlert(
          'Failed',
          '',
          'Failed to fetch similar houses',
          [
            {
              text: 'Ok',
              role: 'confirm',
            },
          ]
        );
      }
    });
  }
  public addHome(): void {
    this.formSubmitted = true;
    if (this.isFormInvalid()) {
      this.alert.presentAlert(
        'Missing Fields',
        '',
        'Please fill in all required fields.',
        [
          {
            text: 'Ok',
            role: 'confirm',
          },
        ]
      );
      return;
    }

    // Check for similar houses before adding
    this.checkSimilarHouseBeforeAdding();
  }

  private async checkSimilarHouseBeforeAdding(): Promise<void> {
    this.api.similarHouse(this.inputs.address1).subscribe(async (data) => {
      if (data.status === 'success' && data.data.count > 0) {
        // Similar house found, show modal
        await this.showSimilarHouseModal(data.data.properties[0]);
      } else {
        // No similar house found, proceed with adding new home
        this.proceedWithAddHome();
      }
    });
  }

  private async showSimilarHouseModal(similarHouse: any): Promise<void> {
    const modal = await this.modalCtrl.create({
      component: SimilarHouseModalComponent,
      componentProps: {
        similarHouse: similarHouse,
        currentFormData: this.inputs,
      },
      cssClass: 'similar-house-modal',
    });

    await modal.present();

    const { data } = await modal.onDidDismiss();
    if (data) {
      if (data.action === 'existing') {
        // User selected existing home - navigate to photo & story
        this.navigateToPhotoStory(data.similarHouse);
      } else if (data.action === 'new') {
        // User wants to create new home - proceed with current flow
        this.proceedWithAddHome();
      }
    }
  }

  private async navigateToPhotoStory(existingHouse: any): Promise<void> {
    const imageToPass =
      this.inputs.home_profile_photo &&
      this.inputs.home_profile_photo.trim() !== ''
        ? this.inputs.home_profile_photo
        : null;

    console.log(
      'Navigating to photo story with image:',
      imageToPass ? imageToPass.substring(0, 50) + '...' : 'No image'
    );

    // Open AddStoryComponent modal with prefilled data
    const modal = await this.modalCtrl.create({
      component: AddStoryComponent,
      componentProps: {
        data: existingHouse.id, // Property ID using the expected 'data' prop
        prefilledPhoto: imageToPass, // Pass the selected image only if it exists
        prefilled: true,
      },
      cssClass: 'add-story-modal',
    });

    await modal.present();

    const { data } = await modal.onDidDismiss();
    if (data && data.success) {
      // Photo & story added successfully, navigate to house detail
      this.alert.presentAlert(
        'Success',
        '',
        'Photo & Story added to existing home successfully!',
        [
          {
            text: 'Ok',
            role: 'confirm',
            handler: () => {
              this.resetInputs();
              // Navigate to the specific house detail page
              this.router.navigate(['/screens/view-detail'], {
                queryParams: {
                  id: existingHouse.id,
                },
              });
            },
          },
        ]
      );
    }
  }

  private proceedWithAddHome(): void {
    let input: any = JSON.stringify(this.inputs);
    this.api.addHome(input).subscribe((data) => {
      if (data.status === 'success') {
        this.alert.presentAlert(
          'Success',
          '',
          'Your Home has been Added Successfully',
          [
            {
              text: 'Ok',
              role: 'confirm',
              handler: () => {
                this.resetInputs();
                this.goToHome('tabs/home');
              },
            },
          ]
        );
      } else {
        this.alert.presentAlert('Failed', '', 'Failed to Add Home', [
          {
            text: 'Ok',
            handler: () => {
              this.goToHome('screens/add-home');
            },
          },
        ]);
      }
    });
  }

  private resetInputs(): void {
    this.inputs = {} as addHome;
  }

  public goToHome(url: string): void {
    this.router.navigate([url]);
  }
  public async takePicture(source: CameraSource): Promise<void> {
    const image: any = await Camera.getPhoto({
      quality: 90,
      allowEditing: false,
      resultType: CameraResultType.Base64,
      source: source,
    });
    this.inputs.home_profile_photo =
      'data:image/jpeg;base64,' + image.base64String;
    this.cdr.detectChanges();
  }
  public async takePictureFromCamera() {
    const actionSheet = await this.actionSheetController.create({
      header: 'Choose an option',
      mode: 'ios',
      cssClass: 'action-sheets-basic-page',
      buttons: [
        {
          text: 'Gallery',
          handler: () => {
            this.takePicture(CameraSource.Photos);
          },
        },
        {
          text: 'Camera',
          handler: () => {
            this.takePicture(CameraSource.Camera);
          },
        },
        {
          text: 'Cancel',
          role: 'cancel',
        },
      ],
    });
    await actionSheet.present();
  }
  public onSelectableChange(event: any, type: string): void {
    if (type === 'material') {
      this.inputs.material_id = event;
    }
    if (type === 'house_style') {
      this.inputs.house_style_id = event;
    }
    if (type === 'state') {
      this.inputs.state = event;
    }
  }

  private findStateObjectByCode(
    stateCode: string
  ): { key: string; value: string } | null {
    if (!this.params?.states || !stateCode) return null;

    const value =
      this.params.states[stateCode as keyof typeof this.params.states];
    return value ? { key: stateCode, value } : null;
  }

  public clearImage() {
    this.inputs.home_profile_photo = '';
    this.cdr.detectChanges();
  }
  private findStateCodeByName(stateName: string): string | null {
    if (!this.params?.states || !stateName) return null;

    const entry = Object.entries(this.params.states).find(
      ([key, value]) => value === stateName
    );
    return entry ? entry[0] : null; // return abbreviation (e.g., "NY")
  }

  /** Close dropdown after a short delay so click on suggestion can fire first. */
  public onAddressBlur(): void {
    setTimeout(() => {
      this.showAddressDropdown = false;
      this.cdr.detectChanges();
    }, 200);
  }

  /** Inline address autocomplete: show suggestions under the field (no map). */
  public onAddressInput(ev: any): void {
    const query = (ev?.detail?.value ?? ev?.target?.value ?? '').trim();
    if (this.addressSearchTimeout) clearTimeout(this.addressSearchTimeout);
    if (!query) {
      this.addressSuggestions = [];
      this.cdr.detectChanges();
      return;
    }
    this.addressSearchTimeout = setTimeout(() => this.runAddressSearch(query), 300);
  }

  private runAddressSearch(query: string): void {
    if (typeof google === 'undefined' || !google.maps?.places?.AutocompleteService) {
      this.addressSuggestions = [];
      this.cdr.detectChanges();
      return;
    }
    const service = new google.maps.places.AutocompleteService();
    service.getPlacePredictions(
      {
        input: query,
        componentRestrictions: { country: ['usa'] },
      },
      (predictions: any[] | null) => {
        this.zone.run(() => {
          this.addressSuggestions = (predictions ?? [])
            .slice(0, 5)
            .map((p: any) => p.description);
          this.cdr.detectChanges();
        });
      }
    );
  }

  /** User selected an address from the dropdown: geocode and fill street, city, state, zip. */
  public selectAddressSuggestion(description: string): void {
    this.showAddressDropdown = false;
    this.addressSuggestions = [];
    if (typeof google === 'undefined' || !google.maps?.Geocoder) {
      this.inputs.address1 = description;
      this.cdr.detectChanges();
      return;
    }
    const geocoder = new google.maps.Geocoder();
    geocoder.geocode({ address: description }, (results: any[] | null, status: any) => {
      this.zone.run(() => {
        const r = Array.isArray(results) ? results : [];
        if (r.length && status === google.maps.GeocoderStatus.OK) {
          const parsed = this.parseAddressFromGeocode(r);
          this.inputs.address1 = parsed.street || description;
          this.inputs.city = parsed.city ?? '';
          this.inputs.state = parsed.state_code ?? '';
          this.selectedStateObject = this.findStateObjectByCode(parsed.state_code ?? '');
          this.inputs.zip = parsed.zip ?? '';
        } else {
          this.inputs.address1 = description;
        }
        this.cdr.detectChanges();
      });
    });
  }

  /** Parse geocoder result into street (short), city, state_code, zip. */
  private parseAddressFromGeocode(results: any[]): { street: string; city: string; state_code: string; zip: string } {
    const res = results[0] || results.find((r: any) => r.formatted_address);
    const components = res?.address_components || [];
    let streetNumber = '';
    let route = '';
    let city = '';
    let stateCode = '';
    let zip = '';
    for (const comp of components) {
      const types = comp.types || [];
      if (types.indexOf('street_number') > -1) streetNumber = comp.long_name;
      if (types.indexOf('route') > -1) route = comp.long_name;
      if (!city && (types.indexOf('locality') > -1 || types.indexOf('postal_town') > -1)) city = comp.long_name;
      if (!city && (types.indexOf('sublocality') > -1 || types.indexOf('administrative_area_level_2') > -1)) city = comp.long_name;
      if (types.indexOf('administrative_area_level_1') > -1) stateCode = comp.short_name || comp.long_name;
      if (types.indexOf('postal_code') > -1) zip = comp.long_name;
    }
    const street = [streetNumber, route].filter(Boolean).join(' ').trim() || (res?.formatted_address ?? '');
    return { street, city, state_code: stateCode, zip };
  }

  public async openLocationModal(): Promise<void> {
    const modal = await this.modalCtrl.create({
      component: AutoCompletePage,
      cssClass: 'auto-complete-modal',
    });
    await modal.present();
    await modal.onDidDismiss().then((data) => {
      console.log('data', data);
      if (data?.data) {
        this.inputs.address1 = data.data.address;
        this.inputs.city = data.data.city;

        // Try abbreviation first, otherwise map full name → code
        let stateCode = data.data.state_code;
        if (!stateCode && data.data.state) {
          stateCode = this.findStateCodeByName(data.data.state);
        }

        this.inputs.state = stateCode || '';
        this.selectedStateObject = this.findStateObjectByCode(stateCode || '');

        this.inputs.zip = data.data.zip;
        this.cdr.detectChanges();
      }
      console.log('The modal was dismissed', data);
    });
  }
}
