import { NgModule } from '@angular/core';
import { CommonModule, DatePipe } from '@angular/common';
import { CardComponent } from './components/card/card.component';
import { IonicModule, IonicRouteStrategy } from '@ionic/angular';
import { RouteReuseStrategy } from '@angular/router';
import { MenuComponent } from './components/menu/menu.component';
import { LivedModelComponent } from './components/lived-model/lived-model.component';
import { FormsModule } from '@angular/forms';
import { FilterModalComponent } from './components/filter-modal/filter-modal.component';
import { IonicSelectableComponent } from 'ionic-selectable';
import { PhotocomponentComponent } from './components/photocomponent/photocomponent.component';
import { FilterphotosComponent } from './components/filterphotos/filterphotos.component';
import { AddPeopleComponent } from './components/add-people/add-people.component';
import { FilterPeopleComponent } from './components/filter-people/filter-people.component';
import { MonitorHomeComponent } from './components/monitor-home/monitor-home.component';
import { PrivacyPolicyComponent } from './components/privacy-policy/privacy-policy.component';
import { PhotoPreviewComponent } from './components/photo-preview/photo-preview.component';
import { DatePicker } from './components/ui/datepicker';
import { CardSkeletonComponent } from './components/card-skeleton/card-skeleton.component';
import { ViewDetailSkeletonComponent } from './components/view-detail-skeleton/view-detail-skeleton.component';
@NgModule({
  declarations: [
    CardComponent,
    PhotoPreviewComponent,
    MenuComponent,
    LivedModelComponent,
    FilterModalComponent,
    PhotocomponentComponent,
    FilterphotosComponent,
    AddPeopleComponent,
    FilterPeopleComponent,
    MonitorHomeComponent,
    PrivacyPolicyComponent,
    DatePicker,
    CardSkeletonComponent,
    ViewDetailSkeletonComponent
  ],
  imports: [
    FormsModule,
    CommonModule,
    IonicSelectableComponent,
    IonicModule.forRoot(),
  ],
  providers: [
    { provide: RouteReuseStrategy, useClass: IonicRouteStrategy },
    DatePipe,
  ],
  exports: [
    MenuComponent,
    CardComponent,
    PhotocomponentComponent,
    FilterphotosComponent,
    LivedModelComponent,
    DatePicker,
    CardSkeletonComponent,
    ViewDetailSkeletonComponent
  ],
})
export class SharedModule {}
