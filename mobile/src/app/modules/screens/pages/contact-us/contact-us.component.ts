import { Component, OnInit } from '@angular/core';
import { ApiService } from 'src/app/core/services/api/http.service';
import { contact } from 'src/app/shared/models/contactUs.model';
import { AlertController } from '@ionic/angular';
import { AlertService } from 'src/app/core/services/alert/alert.service';
import { Router } from '@angular/router';
@Component({
  selector: 'app-contact-us',
  templateUrl: './contact-us.component.html',
  styleUrls: ['./contact-us.component.scss'],
})
export class ContactUsComponent  implements OnInit {
  public contactUs:contact={name: '',message: '',email: '',phone: ''}

  public constructor(public dataService:ApiService,public alert:AlertService,public router:Router) { }

  public ngOnInit():void {}

  public onSubmit(form:any) {
    if (form.valid) { 
      const contact:any = JSON.stringify(this.contactUs);
      this.dataService.contactUs(contact).subscribe(contact =>{ 
      if(contact.status=='success'){
        this.alert.presentAlert('Success', '', 'Your message has been sent successfully', 
          [{
            text: 'Ok',
            handler: () => {
              this.router.navigate(['/tabs/home']);
              this.contactUs= {name: '',message: '',email: '',phone: ''};
            }
          }]
        ); 
      }
      else{ 
        this.alert.presentAlert('Failed', '', 'Failed to send message',
          [{
            text: 'Ok',
            handler: () => {
            this.router.navigate(['/tabs/home']);
            this.contactUs= {name: '',message: '',email: '',phone: ''};
            }
          }]
        );  
      }
      })
    }   
    else{ 
      this.alert.presentAlert('Failed', '', 'Failed to send message',
        [{
          text: 'Ok',
          handler: () => {
          this.contactUs= {name: '',message: '',email: '',phone: ''};
          this.router.navigate(['/tabs/home']);
          }
        }]
      );  
    }
  }
}
