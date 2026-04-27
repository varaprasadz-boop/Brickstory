import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import {
  ActionSheetController,
  ModalController,
  NavParams,
} from '@ionic/angular';
import { ApiService } from 'src/app/core/services/api/http.service';
import { ParamsData } from 'src/app/core/services/api/models/api-response.model';
import { Camera, CameraResultType, CameraSource } from '@capacitor/camera';
import { AlertService } from 'src/app/core/services/alert/alert.service';
import { DatePipe } from '@angular/common';

@Component({
  selector: 'app-add-story',
  templateUrl: './add-story.component.html',
  styleUrls: ['./add-story.component.scss'],
})
export class AddStoryComponent implements OnInit {
  public imageData: string = '';
  public formSubmitted = false;
  public params!: ParamsData;
  public setting: any = [];
  public season: any = [];
  public event: any = [];
  public sideOfHouse: any = [];
  public room: any = [];
  public maxDate: string = '';
  public displayDate: string = '';
  public photoAndStory: any = {
    user_id: '',
    property_id: '',
    approximate_date: '',
    setting_id: '',
    season_id: '',
    event_id: '',
    died_date: '',
    room_id: '',
    side_of_house_id: '',
    brickstory_desc: '',
    image: '',
    image_source: '',
  };
  public constructor(
    public navParams: NavParams,
    private modalCtrl: ModalController,
    public dataService: ApiService,
    private route: ActivatedRoute,
    private actionSheetController: ActionSheetController,
    private cdr: ChangeDetectorRef,
    public alert: AlertService,
    private date: DatePipe
  ) {
    const data = this.navParams.get('data');
    const master_story_id = this.navParams.get('master_story_id');
    const id = this.navParams.get('id');
    
    // Handle new prefilled data for similar house flow
    const prefilledPhoto = this.navParams.get('prefilledPhoto');
    const prefilled = this.navParams.get('prefilled');
    
    // Set property ID
    this.photoAndStory.property_id = data;
    
    if (prefilled && prefilledPhoto) {
      // Set the prefilled photo from add home - use 'image' property not 'photo'
      console.log('Setting prefilled photo:', prefilledPhoto.substring(0, 50) + '...');
      this.photoAndStory.image = prefilledPhoto;
      // Set current date as default
      const currentDate = new Date();
      this.photoAndStory.approximate_date = this.date.transform(currentDate, 'yyyy-MM-dd');
      
      // Trigger change detection to ensure UI updates
      setTimeout(() => {
        this.cdr.detectChanges();
      }, 100);
    }
    
    let user: any = localStorage.getItem('userData');
    user = JSON.parse(user);
    this.photoAndStory.user_id = user.id;
    this.dataService.homeParams().subscribe((response: any) => {
      this.params = response.data;
      this.setting = this.params.settings;
      this.season = this.params.season;
      this.event = this.params.events;
      this.sideOfHouse = this.params.side_of_house;
      this.room = this.params.rooms;
    });
  }

  public ngOnInit(): void {
    // Set max date to today in YYYY-MM-DD format
    const today = new Date();
    this.maxDate = today.toISOString().split('T')[0];
    
    // If there's a prefilled date, format it for display
    if (this.photoAndStory.approximate_date) {
      this.displayDate = this.date.transform(this.photoAndStory.approximate_date, 'MM/dd/yyyy') || '';
    }
  }
  public cancel() {
    return this.modalCtrl.dismiss(null, 'cancel');
  }
  public async takePicture(source: CameraSource): Promise<void> {
    const image: any = await Camera.getPhoto({
      quality: 90,
      allowEditing: false,
      resultType: CameraResultType.Base64,
      source: source,
    });
    this.photoAndStory.image = 'data:image/jpeg;base64,' + image.base64String;
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

  public submit(): void {
    this.formSubmitted = true;
    if (!this.photoAndStory.setting_id) {
      this.scrollToFirstError();
      return;
    }

    if (
      !this.photoAndStory.approximate_date ||
      !this.photoAndStory.brickstory_desc
    ) {
      this.scrollToFirstError();
      return;
    }

    if (this.isIndoorsSelected() && !this.photoAndStory.room_id) {
      this.scrollToFirstError();
      return;
    }

    if (this.isOutdoorsSelected() && !this.photoAndStory.side_of_house_id) {
      this.scrollToFirstError();
      return;
    }
    const date = this.date.transform(
      this.photoAndStory.approximate_date,
      'MM/dd/yyyy'
    );
    this.photoAndStory.approximate_date = date;
    const photoAndStory = JSON.stringify(this.photoAndStory);
    this.dataService.addPhotoAndStory(photoAndStory).subscribe((data) => {
      if (data.status == 'success') {
        this.alert.presentAlert(
          'Success',
          '',
          'Story has been added successfully',
          [
            {
              text: 'OK',
              role: 'confirm',
              handler: () => {
                this.modalCtrl.dismiss({ success: true }, 'confirm');
              },
            },
          ]
        );
      } else {
        this.alert.presentAlert('Failed', '', 'Failed to add story', [
          {
            text: 'OK',
            role: 'cancel',
            handler: () => {
              this.modalCtrl.dismiss({ success: false }, 'fail');
            },
          },
        ]);
      }
    });

    this.formSubmitted = false;
  }

  private scrollToFirstError(): void {
    setTimeout(() => {
      const firstInvalidElement = document.querySelector('.invalid-item');
      if (firstInvalidElement) {
        firstInvalidElement.scrollIntoView({ behavior: 'smooth' });
      }
    }, 100);
  }

  public isIndoorsSelected(): boolean {
    return this.setting[this.photoAndStory.setting_id] === 'Indoors';
  }

  public isOutdoorsSelected(): boolean {
    return this.setting[this.photoAndStory.setting_id] === 'Outdoors';
  }

  public clearImage() {
    this.photoAndStory.image = '';
    this.cdr.detectChanges();
  }

  public onDateSelected(event: any): void {
    const rawDate = event.target.value; // e.g., 2025-06-19
    this.photoAndStory.approximate_date = rawDate;
    this.displayDate = this.date.transform(rawDate, 'MM/dd/yyyy') || '';
  }

  public openDateInput(inputId: string): void {
    const input = document.getElementById(inputId) as HTMLInputElement;
    if (input) {
      input.showPicker();
    }
  }
}
