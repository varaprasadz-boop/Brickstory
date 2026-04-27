import { Component, OnInit } from '@angular/core';
import { Route, Router } from '@angular/router';
import { Subscription } from 'rxjs';
import { AlertService } from 'src/app/core/services/alert/alert.service';
import { ApiService } from 'src/app/core/services/api/http.service';
import { ForgetPasssword } from 'src/app/core/services/api/models/api-payload.model';

@Component({
  selector: 'app-forget-password',
  templateUrl: './forget-password.component.html',
  styleUrls: ['./forget-password.component.scss'],
})
export class ForgetPasswordComponent  implements OnInit {
  
  private forgetubscription: Subscription | undefined;
  public user : ForgetPasssword = {email:''};
  public constructor(private api: ApiService, private router: Router, private alert: AlertService) { }

  public ngOnInit():void{}
  public login(): void {
    this.forgetubscription = this.api
      .forgetPassword(this.user)
      .subscribe((response: any) => {
        if (response.status == 'success') {
          this.alert.presentAlert(response.status, '', response.message, [
            'Ok',
          ]);
          this.router.navigateByUrl('/auth/login');
        } else {
          this.alert.presentAlert(response.message, '', response.data.error, [
            'Try Again',
          ]);
        }
      });
  }
}
