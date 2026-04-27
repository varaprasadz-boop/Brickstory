import { Component, OnDestroy, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Subscription } from 'rxjs';
import { AlertService } from 'src/app/core/services/alert/alert.service';
import { ApiService } from 'src/app/core/services/api/http.service';
import { Login } from 'src/app/core/services/api/models/api-payload.model';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss'],
})
export class LoginComponent implements OnInit, OnDestroy {
  private loginSubscription: Subscription | undefined;
  public user: Login = { email: '', password: '' };
  public constructor(
    private router: Router,
    private api: ApiService,
    private alert: AlertService,
  ) {}

  public ngOnInit(): void {}
 
  public login(): void {
    this.loginSubscription = this.api.login(this.user).subscribe(
      (response: any) => {
        if (response.status === 'success') {
          localStorage.setItem('userData', JSON.stringify(response.data));
          this.router.navigateByUrl('/tabs/home');
        } 
        else {
          this.alert.presentAlert(response.message, '',response.data.error, ['Try Again']);
        }
      },
      (error) => {
        this.alert.presentAlert('Login Failed', 'Invalid email or password. Please try again.', '', ['Try Again']);
      }
    );
  }
  public ngOnDestroy(): void {
    if (this.loginSubscription) {
      this.loginSubscription.unsubscribe();
    }
  }
}
