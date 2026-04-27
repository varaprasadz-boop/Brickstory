import { Component, Inject, inject, OnInit } from '@angular/core';
import { NgForm } from '@angular/forms';
import { Router } from '@angular/router';
import { Subscription } from 'rxjs';
import { AlertService } from 'src/app/core/services/alert/alert.service';
import { ApiService } from 'src/app/core/services/api/http.service';
import { Signup } from 'src/app/core/services/api/models/api-payload.model';
import { comparePasswords } from './functions/validator';
import { ModalController } from '@ionic/angular';
import { PrivacyPolicyComponent } from 'src/app/shared/components/privacy-policy/privacy-policy.component';
@Component({
  selector: 'app-signup',
  templateUrl: './signup.component.html',
  styleUrls: ['./signup.component.scss'],
})
export class SignupComponent  implements OnInit {
  private signupSubscription: Subscription | undefined;
  public user : Signup = {
    firstname: '',
    lastname: '',
    email: '',
    password: '',
    confirm_password: ''
  };
  public constructor( public router:Router, private alert: AlertService, private api: ApiService, private modalController: ModalController) { }

  public ngOnInit():void {}
  
  public signup(form: NgForm): void {
    if (form.valid) { 
      this.api.signup(this.user).subscribe((response:any) => { 
        if(response.status == 'success') { 
          this.router.navigateByUrl('/auth/login');
        }
        else if (response.status == 'failure') {
          this.alert.presentAlert(response.message,'',response.data.error,['Try Again'])
        }
      })
    } 
    else {
      this.alert.presentAlert('Failed', 'There are errors in your registration information', '',['Try Again']);
    }
  }
  public login(){
    this.router.navigate(['/auth/login'])
  }
  public back(){
    this.router.navigate(['home'])
  }
  public close(){
    this.router.navigate(['home'])
  }
  public reg(){
    this.router.navigate(['/auth/login'])
  }
  public ngOnDestroy(): void {
    if (this.signupSubscription) {
      this.signupSubscription.unsubscribe();
    }
  }
  public async termsConditions() : Promise<void> {
    this.api.termsAndConditions().subscribe(async (response:any) => {
      if(response.status == 'success') {
        const modal = await this.modalController.create({
          component: PrivacyPolicyComponent,
          componentProps : {
            data : response.data.page.description
          }
        });
        await modal.present();
      }
    });
  }
}
