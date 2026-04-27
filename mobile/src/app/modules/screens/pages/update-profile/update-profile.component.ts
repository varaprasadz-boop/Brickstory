import { ChangeDetectorRef, Component, OnInit, inject } from '@angular/core';
import { Data, Router } from '@angular/router';
import { ActionSheetController, NavController, ViewDidEnter, ViewWillEnter } from '@ionic/angular';
import { AlertService } from 'src/app/core/services/alert/alert.service';
import { ApiService } from 'src/app/core/services/api/http.service';
import { Signup, UpdateProfile } from 'src/app/core/services/api/models/api-payload.model';
import { StorageService } from 'src/app/core/services/storage/storage.service';
import { Camera, CameraResultType, CameraSource } from '@capacitor/camera';
@Component({
  selector: 'app-update-profile',
  templateUrl: './update-profile.component.html',
  styleUrls: ['./update-profile.component.scss'],
})
export class UpdateProfileComponent implements OnInit, ViewDidEnter {
  public localStorage = inject(StorageService);
  public updateProfileImage: any = { user_id: '', profile_image: '' }
  private api = inject(ApiService);
  private alert = inject(AlertService)
  public defaultImage: string = '../../../../assets/img/story.png';
  public imageSrc!: string;
  public user: UpdateProfile = {
    user_id: 0,
    firstname: '',
    lastname: '',
    email: '',
    address: '',
    city: '',
    state: '',
    zip: ''
  };
  public profile: any = {
    id: '',
    user_id: '',
    role_id: '',
    firstname: '',
    lastname: '',
    email: '',
    password: '',
    fb_id: '',
    address: '',
    city: '',
    state: '',
    zip: '',
    profile_photo: '',
    activation_code: '',
    activation_expiry: '',
    last_login: '',
    status: '',
    created: '',
    modified: '',
    is_locked: '',
    lock_datetime: '',
    lock_user_id: '',
  };

  public constructor(private cdr: ChangeDetectorRef, public router: Router, public dataService: ApiService, private actionSheetController: ActionSheetController, private navCtrl: NavController) {
    let user: any = localStorage.getItem('userData');
    user = JSON.parse(user);
    this.updateProfileImage.user_id = user.id;
    this.updateProfileImage.profile_image = user.profile_photo; 
  }

  public ngOnInit(): void {
  }
  public ionViewDidEnter(): void {
    this.profile = this.getLoggedUser();

  }
  public getLoggedUser(): Data {
    let user: any = localStorage.getItem('userData')
      ? localStorage.getItem('userData')
      : [];
    return (user = JSON.parse(user));
  }
  public checkImage(url: string): Promise<boolean> {
    return new Promise((resolve) => {
      const img = new Image();
      img.onload = () => resolve(true);
      img.onerror = () => resolve(false);
      img.src = url;
    });
  }
  public loadFile(event: any) {
    const file = event.target.files[0];
    const reader = new FileReader();
    reader.onload = () => {
      const data = JSON.stringify(this.updateProfileImage)
      this.dataService.updateProfileImage(data).subscribe(data => {
        localStorage.setItem('userData', JSON.stringify(data.data));
        this.updateProfileImage.profile_image = reader.result as string;
      })

    };
    reader.readAsDataURL(file);
  }
  public onClick(): void {
    this.router.navigate(['/tabs/profile'])
  }
  public updateProfile(): void {
    let profile = this.profile;
    let profileData: any = localStorage.getItem('userData');
    profileData = JSON.parse(profileData);
    profile.user_id = profileData.id;
    this.api.updateProfile(this.profile)
      .subscribe((response: any) => {
        if (response.status == 'success') {
          localStorage.setItem('userData', JSON.stringify(response.data));
          this.router.navigateByUrl('/tabs/profile');
        } else {
          this.alert.presentAlert(response.message, '', response.data.error, [
            'Try Again',
          ]);
        }
      });
  }

  public async takePicture(source: CameraSource): Promise<void> {
    const image: any = await Camera.getPhoto({
      quality: 90,
      allowEditing: false,
      resultType: CameraResultType.Base64,
      source: source,
    });
    this.updateProfileImage.profile_image = 'data:image/jpeg;base64,' + image.base64String;
    this.cdr.detectChanges();
    this.dataService.updateProfileImage(this.updateProfileImage).subscribe(res => {
      if (res.status === 'success') {
        localStorage.setItem('userData', JSON.stringify(res.data)); 
      }
      else {
        this.alert.presentAlert(res.message, '', res.data.error, ['Try Again']);
      }
    })
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
  public navigate(): void {
    this.router.navigate(['/tabs/profile']);
  }
}
