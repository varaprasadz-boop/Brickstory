import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { TabsPage } from './ui/tabs.page';
import { HomeComponent } from './pages/home/home.component';
import { ProfileComponent } from './pages/profile/profile.component';
import { LocationComponent } from './pages/location/location.component';
import { permissionGuard } from 'src/app/core/guard/permission.guard';
import { NotificationsComponent } from './pages/notifications/notifications.component';
import { AllHouseComponent } from '../screens/pages/all-house/all-house.component';

const routes: Routes = [
  {
    path: '',
    component: TabsPage,
    children: [
      {
        path: 'home',
        component:HomeComponent
      },
      {
        path: 'profile',
        canActivate:[permissionGuard],
        component:ProfileComponent
      },
      {
        path: 'location',
        component:LocationComponent
      },
      {
        path: 'notifications',
        component:NotificationsComponent
      },
      {
        path: 'all-house',
        component:AllHouseComponent
      },
      {
        path: '',
        redirectTo: '/tabs/home',
        pathMatch: 'full'
      }
    ]
  },
  {
    path: '',
    redirectTo: '/tabs/home',
    pathMatch: 'full'
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  declarations: [],
})
export class TabsPageRoutingModule {}
