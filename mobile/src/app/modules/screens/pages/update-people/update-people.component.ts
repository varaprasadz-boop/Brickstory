import { DatePipe } from '@angular/common';
import { ChangeDetectorRef, Component, Input, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Camera, CameraResultType, CameraSource } from '@capacitor/camera';
import { ActionSheetController, ModalController, NavParams } from '@ionic/angular';
import { AlertService } from 'src/app/core/services/alert/alert.service';
import { ApiService } from 'src/app/core/services/api/http.service';
import { IMinDates } from 'src/app/shared/models/photo-story.model';
@Component({
  selector: 'app-update-people',
  templateUrl: './update-people.component.html',
  styleUrls: ['./update-people.component.scss'],
})
export class UpdatePeopleComponent  implements OnInit {
  public peopleDetail:any;
  public imageData: string = '';
  public minDates: IMinDates = {from_date: '', born_date: ''};
  public relations:any=[]
  public updatePeople:any={
  people_id:'',
  property_id:'',
  user_id:'',
  from_date:'',
  to_date:'',
  first_name:'',
  last_name:'',
  relation_id:'',
  born_date:'',
  died_date:'',
  living:'',
  image:'',
  image_source:''
}
  public constructor(public dates: DatePipe,private modalCtrl: ModalController,public navParams: NavParams,public dataService:ApiService,private cdr: ChangeDetectorRef,private  actionSheetController: ActionSheetController,private datePipe: DatePipe,public alert:AlertService,public router:Router) {
    this.peopleDetail = this.navParams.get('peopleDetail');
    this.updatePeople.first_name=this.peopleDetail.frist_name;
    this.updatePeople.last_name=this.peopleDetail.last_name;
    this.updatePeople.relation_id=this.peopleDetail.relation_id;
    const date = new Date(this.peopleDetail.from_date);
    this.updatePeople.from_date=  date.toISOString().split('T')[0];
    const date2 = new Date(this.peopleDetail.to_date);
    this.updatePeople.to_date=date2.toISOString().split('T')[0];
    const date3 = new Date(this.peopleDetail.born_date);
    this.updatePeople.born_date=date3.toISOString().split('T')[0];
    this.updatePeople.died_date=this.peopleDetail.died_date;
    this.updatePeople.living=this.peopleDetail.living;
    this.updatePeople.image=this.peopleDetail.person_photo;
    this.updatePeople.people_id=this.peopleDetail.id;
    this.updatePeople.property_id=this.peopleDetail.master_story_id;
    this.updatePeople.user_id=this.peopleDetail.user_id;
    this.updatePeople.image_source=this.peopleDetail.image_source;
    this.dataService.homeParams().subscribe(data =>{
      this.relations=data.data.relationship;
      })
   }

  public ngOnInit():void {}

  public async takePicture(source:CameraSource): Promise<void> {
    const image:any = await Camera.getPhoto({
      quality: 90,
      allowEditing: false,
      resultType: CameraResultType.Base64,
      source:source,
    });
    this.updatePeople.image = 'data:image/jpeg;base64,'+image.base64String;
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
  public cancel() {
    return this.modalCtrl.dismiss(null, 'cancel');
  }
  public updatePeopleDetail(){
    this.dataService.updatePeople(this.updatePeople).subscribe({
      next: (res: any) => {
        if (res.status === 'success') {
          this.alert.presentAlert('Success', '', 'People has been updated successfully', [
            {
              text: 'OK',
              role: 'confirm',
              handler: () => {
                this.router.navigate(['/screens/my-people'])
                this.modalCtrl.dismiss(res, 'confirm');
              },
            },
          ]);
        } else {
          this.alert.presentAlert('Failed', '', 'People Not updated successfully', [
            {
              text: 'OK',
              role: 'cancel',
              handler: () => {
                this.router.navigate(['/screens/my-people'])
                this.modalCtrl.dismiss(null, 'cancel');
              },
            },
          ]);
        }
      },
      error: (err) => {
        console.error('API Error:', err);
        this.alert.presentAlert('Error', '', 'An error occurred while updating People', [
          {
            text: 'OK',
            role: 'cancel',
            handler: () => {
              this.router.navigate(['/screens/my-people'])
              this.modalCtrl.dismiss(null, 'cancel');
            },
          },
        ]);
      }
    });
  }
  public clearImage() {
    this.updatePeople.image = '';
    this.cdr.detectChanges();
  }

  public selectedDate(event: any, type: any) {
    switch (type) {
      case 'from':
        this.minDates.from_date = event.detail.value;
        this.updatePeople.from_date = this.dates.transform(
          event.detail.value,
            'dd-MM-yyyy'
        );
        break;
      case 'to':
        this.updatePeople.to_date = this.dates.transform(
          event.detail.value,
            'dd-MM-yyyy'
        );
        break;
      case 'born':
        this.minDates.born_date = event.detail.value;
        this.updatePeople.born_date = this.dates.transform(
          event.detail.value,
          'dd-MM-yyyy'
        );
        break;
      case 'died':
        this.updatePeople.died_date = this.dates.transform(
          event.detail.value,
             'dd-MM-yyyy'
        );
        break;
    }
  }
}
