import {
  AfterViewInit,
  ChangeDetectorRef,
  Component,
  ElementRef,
  OnInit,
  ViewChild,
} from '@angular/core';
import {
  ActionSheetController,
  ModalController,
  NavParams,
} from '@ionic/angular';
import { ApiService } from 'src/app/core/services/api/http.service';
import { Camera, CameraResultType, CameraSource } from '@capacitor/camera';
import { AlertService } from 'src/app/core/services/alert/alert.service';
import { DatePipe } from '@angular/common';
import { IMinDates, IPeople } from '../../models/photo-story.model';
@Component({
  selector: 'app-add-people',
  templateUrl: './add-people.component.html',
  styleUrls: ['./add-people.component.scss'],
})
export class AddPeopleComponent implements OnInit, AfterViewInit {
  @ViewChild('dateInput', { static: false }) dateInput!: ElementRef;
  public imageData: string = '';
  public formSubmitted: boolean = false;
  public minDates: IMinDates = { from_date: '', born_date: '' };
  public maxDate: string = '';
  public relations: any = [];
  public displayDates = {
    from_date: '',
    to_date: '',
    born_date: '',
    died_date: ''
  };
  public people: IPeople = {
    user_id: '',
    property_id: '',
    from_date: '',
    to_date: '',
    first_name: '',
    last_name: '',
    relation_id: '',
    born_date: '',
    died_date: '',
    living: 0,
    image: '',
    image_source: ''
  };
  public constructor(
    public date: DatePipe,
    private modalCtrl: ModalController,
    public dataService: ApiService,
    private navParams: NavParams,
    private actionSheetController: ActionSheetController,
    private cdr: ChangeDetectorRef,
    public alert: AlertService
  ) {
    const data = this.navParams.get('data');
    this.people.property_id = data;
    this.people.property_id = data;
    let user: any = localStorage.getItem('userData');
    user = JSON.parse(user);
    this.people.user_id = user.id;
    this.dataService.homeParams().subscribe((data) => {
      this.relations = data.data.relationship;
    });
  }

  public ngOnInit() {
    // Set max date to today in YYYY-MM-DD format
    const today = new Date();
    this.maxDate = today.toISOString().split('T')[0];
  }

  public ngAfterViewInit() {
    if (this.dateInput) {
      this.dateInput.nativeElement.addEventListener('click', (event: any) => {
        event.stopPropagation();
      });
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
    this.people.image = 'data:image/jpeg;base64,' + image.base64String;
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
  public addPeople(): void {
    this.formSubmitted = true;
    console.log(this.people);
    if (this.isFormInvalid()) {
      this.alert.presentAlert(
        'Missing Fields',
        '',
        'Please fill in all required fields.',
        [
          {
            text: 'OK',
            role: 'confirm',
          },
        ]
      );
      return;
    }
    const people = JSON.stringify(this.people);
    this.dataService.addPeople(people).subscribe((data) => {
      if (data.status === 'success') {
        this.alert.presentAlert(
          'Success',
          '',
          'People has been added successfully',
          [
            {
              text: 'OK',
              role: 'confirm',
              handler: () => {
                this.modalCtrl.dismiss(data.data, 'confirm');
              },
            },
          ]
        );
      } else {
        this.alert.presentAlert('Failed', '', 'People Not added successfully', [
          {
            text: 'OK',
            role: 'cancel',
          },
        ]);
      }
    });
  }
  private isFormInvalid(): boolean {
    return (
      !this.people.first_name ||
      !this.people.last_name ||
      !this.people.from_date ||
      !this.people.born_date 
    );
  }
  public onDateSelected(event: any, type: string): void {
    const rawDate = event.target.value; // e.g., 2025-06-19
    const formatted = this.date.transform(rawDate, 'MM/dd/yyyy');

    switch (type) {
      case 'from':
        this.people.from_date = formatted!;
        this.displayDates.from_date = formatted!;
        this.minDates.from_date = rawDate; // Keep original for [min]
        break;
      case 'to':
        this.people.to_date = formatted!;
        this.displayDates.to_date = formatted!;
        break;
      case 'born':
        this.people.born_date = formatted!;
        this.displayDates.born_date = formatted!;
        this.minDates.born_date = rawDate; // Keep original for [min]
        break;
      case 'died':
        this.people.died_date = formatted!;
        this.displayDates.died_date = formatted!;
        break;
    }
  }

  public openDateInput(inputId: string): void {
    const input = document.getElementById(inputId) as HTMLInputElement;
    if (input) {
      input.showPicker();
    }
  }

  public clearImage() {
    this.people.image = '';
    this.cdr.detectChanges();
  }
  public openDatePicker() {
    if (this.dateInput) {
      this.dateInput.nativeElement.click();
    }
  }
}
