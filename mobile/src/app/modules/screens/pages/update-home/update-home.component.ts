import { ChangeDetectorRef, Component, Input, NgZone, OnInit } from '@angular/core';
import {
  ActionSheetController,
  NavParams,
  ModalController,
} from '@ionic/angular';
import { Camera, CameraResultType, CameraSource } from '@capacitor/camera';
import { ApiService } from 'src/app/core/services/api/http.service';
import { AlertService } from 'src/app/core/services/alert/alert.service';
import { Router } from '@angular/router';
import { ParamsData } from 'src/app/core/services/api/models/api-response.model';

declare var google: any;

@Component({
  selector: 'app-update-home',
  templateUrl: './update-home.component.html',
  styleUrls: ['./update-home.component.scss'],
})
export class UpdateHomeComponent implements OnInit {
  @Input() public params: ParamsData = {} as ParamsData;
  @Input() public homeDetails: any = {
    id: '',
    home_id: '',
    user_id: '',
    address1: '',
    city: '',
    owner_name: '',
    architech: '',
    square_feet: '',
    address2: '',
    state: '',
    zip: '',
    year_built: '',
    house_style_id: '',
    bedroom_id: '',
    material_id: '',
    from_date: '00',
    to_date: '00',
    home_profile_photo: '',
    status: '1',
    image_source: '',
  };

  public formSubmitted = false;
  public imageData = '';

  houseStyles: { key: string; value: string }[] = [];
  materials: { key: string; value: string }[] = [];
  states: { key: string; value: string }[] = [];
  selectedStateObject: { key: string; value: string } | null = null;

  /** Inline address autocomplete (no map modal) */
  public addressSuggestions: string[] = [];
  public showAddressDropdown = false;
  private addressSearchTimeout: any;

  constructor(
    public api: ApiService,
    public navParam: NavParams,
    private modalCtrl: ModalController,
    private actionSheetController: ActionSheetController,
    private cdr: ChangeDetectorRef,
    public alert: AlertService,
    public router: Router,
    private zone: NgZone
  ) {}

  selectedHouseStyle: { key: string; value: string } | null = null;
  selectedMaterial: { key: string; value: string } | null = null;

  ngOnInit(): void {
    this.states = Object.entries(this.params?.states || {}).map(([key, value]) => ({
      key,
      value: (value as string) || '',
    }));

    if (this.homeDetails.state) {
      this.selectedStateObject = this.findStateObjectByCode(this.homeDetails.state);
    }

    if (this.homeDetails.house_style_id) {
      this.selectedHouseStyle =
        Object.entries(this.params?.house_style || {})
          .map(([key, value]) => ({ key, value: value as string }))
          .find((s) => s.key === this.homeDetails.house_style_id) ?? null;
    }

    if (this.homeDetails.material_id) {
      this.selectedMaterial =
        Object.entries(this.params?.material || {})
          .map(([key, value]) => ({
            key,
            value:
              typeof value === 'string' ? value : (value as any)?.name || '',
          }))
          .find((m) => m.key === this.homeDetails.material_id) ?? null;
    }
  }

  public onSelectableChange(event: any, type: string): void {
    if (type === 'material') {
      this.homeDetails.material_id = event;
    } else if (type === 'house_style') {
      this.homeDetails.house_style_id = event;
    } else if (type === 'state') {
      this.homeDetails.state = event;
    } else if (type === 'bedroom') {
      this.homeDetails.bedroom_id = event;
    }
  }

  // Utilities
  private findStateObjectByCode(
    stateCode: string
  ): { key: string; value: string } | null {
    return this.states.find((s) => s.key === stateCode) ?? null;
  }

  private findStateCodeByName(name: string): string | null {
    const state = this.states.find(
      (s) => s.value.toLowerCase() === name.toLowerCase()
    );
    return state ? state.key : null;
  }

  public onAddressBlur(): void {
    setTimeout(() => {
      this.showAddressDropdown = false;
      this.cdr.detectChanges();
    }, 200);
  }

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
      { input: query, componentRestrictions: { country: ['usa'] } },
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

  public selectAddressSuggestion(description: string): void {
    this.showAddressDropdown = false;
    this.addressSuggestions = [];
    if (typeof google === 'undefined' || !google.maps?.Geocoder) {
      this.homeDetails.address1 = description;
      this.cdr.detectChanges();
      return;
    }
    const geocoder = new google.maps.Geocoder();
    geocoder.geocode({ address: description }, (results: any[] | null, status: any) => {
      this.zone.run(() => {
        const r = Array.isArray(results) ? results : [];
        if (r.length && status === google.maps.GeocoderStatus.OK) {
          const parsed = this.parseAddressFromGeocode(r);
          this.homeDetails.address1 = parsed.street || description;
          this.homeDetails.city = parsed.city ?? '';
          this.homeDetails.state = parsed.state_code ?? '';
          this.selectedStateObject = this.findStateObjectByCode(parsed.state_code ?? '');
          this.homeDetails.zip = parsed.zip ?? '';
        } else {
          this.homeDetails.address1 = description;
        }
        this.cdr.detectChanges();
      });
    });
  }

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

  // Modal
  public cancel() {
    return this.modalCtrl.dismiss(null, 'cancel');
  }

  // Camera
  public async takePicture(source: CameraSource): Promise<void> {
    const image = await Camera.getPhoto({
      quality: 90,
      allowEditing: false,
      resultType: CameraResultType.Base64,
      source,
    });
    this.homeDetails.home_profile_photo =
      'data:image/jpeg;base64,' + image.base64String;
    this.cdr.detectChanges();
  }

  public async takePictureFromCamera() {
    const actionSheet = await this.actionSheetController.create({
      header: 'Choose an option',
      mode: 'ios',
      buttons: [
        {
          text: 'Gallery',
          handler: () => this.takePicture(CameraSource.Photos),
        },
        {
          text: 'Camera',
          handler: () => this.takePicture(CameraSource.Camera),
        },
        { text: 'Cancel', role: 'cancel' },
      ],
    });
    await actionSheet.present();
  }

  public clearImage() {
    this.homeDetails.home_profile_photo = '';
    this.cdr.detectChanges();
  }



  // Submit
  public updateHomeDetail(): void {
    this.formSubmitted = true;

    if (
      !this.homeDetails.address1 ||
      !this.homeDetails.city ||
      !this.homeDetails.state ||
      !this.homeDetails.year_built
    ) {
      this.alert.presentAlert(
        'Missing Fields',
        '',
        'Please fill in all required fields.',
        [{ text: 'Ok', role: 'confirm' }]
      );
      return;
    }

    this.homeDetails.home_id = this.homeDetails.id;
    const homeDetails = { ...this.homeDetails };
    delete homeDetails.house_style_value;
    delete homeDetails.material_value;
    delete homeDetails.roof_value;
    delete homeDetails.foundation_value;
    delete homeDetails.bedroom_value;

    this.api.updatehome(homeDetails).subscribe({
      next: (data: any) => {
        if (data.status === 'success') {
          this.alert.presentAlert(
            'Success',
            '',
            'Your Home Details has been Updated Successfully',
            [
              {
                text: 'Ok',
                handler: () => {
                  this.router.navigate(['/screens/my-home']);
                  this.modalCtrl.dismiss(null, 'update');
                },
              },
            ]
          );
        } else {
          this.alert.presentAlert('Failed', '', 'Failed to update Home', [
            {
              text: 'Ok',
              handler: () => {
                this.router.navigate(['/screens/my-home']);
                this.modalCtrl.dismiss(null, 'update');
              },
            },
          ]);
        }
      },
      error: (err) => {
        console.error('API Error:', err);
        this.alert.presentAlert(
          'Error',
          '',
          'An error occurred while updating Home',
          [
            {
              text: 'Ok',
              role: 'alert',
              handler: () => {
                this.router.navigate(['/screens/my-home']);
                this.modalCtrl.dismiss(null, 'update');
              },
            },
          ]
        );
      },
    });
  }
}
