import { Component, OnDestroy, OnInit, inject } from '@angular/core';
import { NavigationEnd, Router } from '@angular/router';
import { MenuController, ViewDidEnter, ViewWillEnter } from '@ionic/angular';
import { Subscription } from 'rxjs';
import { Data } from 'src/app/core/services/api/models/api-response.model';
import { StorageService } from 'src/app/core/services/storage/storage.service';
@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.scss'],
})
export class ProfileComponent implements OnInit,OnDestroy, ViewWillEnter {
  public localStorage = inject(StorageService);
  public defaultImage: string = '../../../../../assets/img/logo.jpg';
  public imageSrc: any;
  private subscription!: Subscription;
  public profile: Data = {
    id: '',
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
  public constructor(
    public menuController: MenuController,
    public router: Router
  ) {
    this.profile = this.getLoggedUser();
    this.imageSrc = this.profile.profile_photo;
  }

  public ngOnInit(): void {
    this.subscription = this.router.events.subscribe(event => {
      if (event instanceof NavigationEnd) {
        const currentUrl = this.router.url;
        if (currentUrl.includes('/tabs/profile')) {
          this.profile = this.getLoggedUser();
          this.imageSrc = this.profile.profile_photo;
        }
      }
    });
  }
  public ionViewWillEnter(): void {
    this.profile = this.getLoggedUser();
    this.imageSrc = this.profile.profile_photo;
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
  public onClick(): void {
    this.router.navigate(['/screens/my-home']);
  }
  public goToupdate(): void {
    this.router.navigate(['/screens/update-profile']);
  }
  public mytimeline(): void {
    this.router.navigate(['/screens/my-timeline']);
  }
  public mypeople(): void {
    this.router.navigate(['/screens/my-people']);
  }
  public goToSetting(): void {
    this.router.navigate(['/screens/setting']);
  }
  public mystories():void{
    this.router.navigate(['/screens/my-stories']);
  }
  public logOut(): void {
    this.localStorage.logout();
  }
  public ngOnDestroy() :void {
    if (this.subscription) {
      this.subscription.unsubscribe();
    }
  }
}
