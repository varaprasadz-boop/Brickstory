import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { ActionSheetController, NavParams } from '@ionic/angular';
import { ModalController } from '@ionic/angular';
import { Camera, CameraResultType, CameraSource } from '@capacitor/camera';
import { AlertService } from 'src/app/core/services/alert/alert.service';
import { ApiService } from 'src/app/core/services/api/http.service';
import { ParamsData } from 'src/app/core/services/api/models/api-response.model';
import { Router } from '@angular/router';
@Component({
  selector: 'app-update-stories',
  templateUrl: './update-stories.component.html',
  styleUrls: ['./update-stories.component.scss'],
})
export class UpdateStoriesComponent  implements OnInit {
  public imageData: string = '';
  public params!: ParamsData;
  public setting: any = [];
  public season: any = [];
  public event: any = [];
  public sideOfHouse: any = [];
  public room: any = [];
   public photoAndStory:any={
   story_id:'',
   property_id:'',
   user_id:'',
   approximate_date:'',
   setting_id:'',
   season_id:'',
   event_id:'',
   died_date:'',
   room_id:'',
   side_of_house_id:'',
   brickstory_desc: '',
   image:'',
    image_source:''
}
  constructor(public navParam:NavParams,public  modalController: ModalController,private actionSheetController: ActionSheetController, private cdr: ChangeDetectorRef, public alert: AlertService,public dataService:ApiService,public router:Router) {
   const data=  this.navParam.get('data'); 
   this.photoAndStory=data;
   this.photoAndStory.story_id=data.id;
   this.photoAndStory.property_id=data.master_story_id;
   this.photoAndStory.user_id=data.user_id;
   this.photoAndStory.brickstory_desc=data.story_description;
   this.photoAndStory.image=data.story_photo;
    this.photoAndStory.image_source=data.image_source;
   this.dataService.homeParams().subscribe((response: any) => {
    this.params = response.data;
    this.setting = this.params.settings;
    this.season = this.params.season;
    this.event = this.params.events;
    this.sideOfHouse = this.params.side_of_house;
    this.room = this.params.rooms;
  })
   }

  public ngOnInit() {}

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
  public cancel() {
    return this.modalController.dismiss(null, 'cancel');
  }
  public isOutdoorsSelected(): boolean {
    return this.setting[this.photoAndStory.setting_id] === 'Outdoors';
  }
 
 public updateStories():void{
  this.dataService.updateStories(this.photoAndStory).subscribe(data => { 
    if (data.status === 'success') {
      this.alert.presentAlert('Success', '', 'Story has been updated successfully', [{
        text: 'OK',
        role: 'confirm',
        handler: () => {
          this.router.navigate(['/screens/my-stories']);
          this.modalController.dismiss(null, 'success');
        },
      }]);
    } else if (data.status === 'fail') {
      this.alert.presentAlert('Failed', '', 'Failed to update story', [{
        text: 'OK',
        role: 'cancel',
        handler: () => {
          this.router.navigate(['/screens/my-stories']);
          this.modalController.dismiss(null, 'fail');
        },
      }]);
    } else { 
      this.alert.presentAlert('Error', '', 'An unexpected error occurred', [{
        text: 'OK',
        role: 'cancel',
        handler: () => {
          this.router.navigate(['/screens/my-stories']);
          this.modalController.dismiss(null, 'error');
        },
      }]);
    }
  });
  }

  public clearImage() {
    this.photoAndStory.image = '';
    this.cdr.detectChanges(); 
  }
}
