import { Injectable, inject } from '@angular/core';
import { Router } from '@angular/router';
import { AlertService } from '../alert/alert.service';
import { LoginResponse } from '../api/models/api-response.model';

@Injectable({
  providedIn: 'root',
})
export class StorageService {
  private router = inject(Router);
  private alert = inject(AlertService)
  public constructor() {}
  public isLoggedIn():boolean {
    return localStorage.getItem('userData') == null ? false : true;
  }
  public logout():void {
    this.alert.presentAlert('Logout?','','Are you sure?',[
      {
        text: 'Cancel',
        role: 'cancel',
        handler: () => {
          console.log('Alert canceled');
        },
      },
      {
        text: 'OK',
        role: 'confirm',
        handler: () => {
          localStorage.removeItem('userData');
          this.router.navigate(['/tabs/home']);
        },
      },
    ])
  }
}
