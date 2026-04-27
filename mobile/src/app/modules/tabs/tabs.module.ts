import { IonicModule } from '@ionic/angular';
import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { TabsPageRoutingModule } from './tabs-routing.module';
import { TabsPage } from './ui/tabs.page';
import { CUSTOM_ELEMENTS_SCHEMA } from '@angular/core';
import { HomeComponent } from './pages/home/home.component';
import { SharedModule } from 'src/app/shared/shared.module';
import { ProfileComponent } from './pages/profile/profile.component';
import { LocationComponent } from './pages/location/location.component';
import { NotificationsComponent } from './pages/notifications/notifications.component';
@NgModule({
  schemas: [CUSTOM_ELEMENTS_SCHEMA],
  imports: [
    SharedModule,
    IonicModule,
    CommonModule,
    FormsModule,
    TabsPageRoutingModule,
    IonicModule.forRoot(),
  ],
  declarations: [TabsPage,HomeComponent,ProfileComponent,LocationComponent,NotificationsComponent]
})
export class TabsPageModule {}
