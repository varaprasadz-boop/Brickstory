import { NgModule } from '@angular/core';
import { CommonModule, TitleCasePipe } from '@angular/common';
import { IonicModule } from '@ionic/angular';



@NgModule({
  declarations: [],
  imports: [
    CommonModule,
    IonicModule.forRoot({innerHTMLTemplatesEnabled:true})
  ],
  providers:[TitleCasePipe],
  exports:[TitleCasePipe]
})
export class CoreModule { }
