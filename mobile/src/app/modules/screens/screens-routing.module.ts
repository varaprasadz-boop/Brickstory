import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { AddHomeComponent } from './pages/add-home/add-home.component';
import { AboutBrickComponent } from './pages/about-brick/about-brick.component';
import { ViewDetailComponent } from './pages/view-detail/view-detail.component';
import { MyHomeComponent } from './pages/my-home/my-home.component';
import { UpdateProfileComponent } from './pages/update-profile/update-profile.component';
import { MyTimelineComponent } from './pages/my-timeline/my-timeline.component';
import { SettingComponent } from './pages/setting/setting.component';
import { permissionGuard } from 'src/app/core/guard/permission.guard';
import { ContactUsComponent } from './pages/contact-us/contact-us.component';
import { HowItWorksComponent } from './pages/how-it-works/how-it-works.component';
import { PeopleComponent } from './pages/people/people.component';
import { ArchitectComponent } from './pages/architect/architect.component';
import { ParamResolver } from 'src/app/core/resolvers/param.resolver.service';
import { authGuard } from 'src/app/core/guard/auth.guard';
import { PhotoAndStoriesComponent } from './pages/photo-and-stories/photo-and-stories.component';
import { ViewPhotosComponent } from './pages/view-photos/view-photos.component';
import { FilterphotosComponent } from 'src/app/shared/components/filterphotos/filterphotos.component';
import { AddStoryComponent } from 'src/app/shared/components/add-story/add-story.component';  
import { UpdateHomeComponent } from './pages/update-home/update-home.component';
import { MyPeopleComponent } from './pages/my-people/my-people.component';
import { UpdatePeopleComponent } from './pages/update-people/update-people.component';
import { MyStoriesComponent } from './pages/my-stories/my-stories.component';
import { UpdateStoriesComponent } from './pages/update-stories/update-stories.component';
import { PropertyDetailsResolver } from 'src/app/core/resolvers/property-details.resolver';
import { AllHouseComponent } from './pages/all-house/all-house.component';
const routes: Routes = [
  {
    path:'',
    children:[
      {
        path:'add-home',
        canActivate:[permissionGuard],
        resolve: {
          data : ParamResolver
        },
        component:AddHomeComponent
      },
      {
        path:'about',
        component:AboutBrickComponent,
      },
      {
        path:'update-stories',
        component:UpdateStoriesComponent,
      },
      {
        path:'all-house',
        component:AllHouseComponent,
      },
      {
        path: 'view-detail/:id/:segment/:pid',
        component: ViewDetailComponent,
        resolve: { homeDetails: PropertyDetailsResolver },
      },
      {
        path:'my-stories',
        component:MyStoriesComponent,
      },
      {
        path:'view-photos',
        component:ViewPhotosComponent,
      },
      {
        path:'my-home',
        component:MyHomeComponent,
      },
      {
        path:'update-profile',
        canActivate:[permissionGuard],
        component:UpdateProfileComponent,
      },
      {
        path:'update-home',
        canActivate:[permissionGuard],
        component:UpdateHomeComponent,
      },
      {
        path:'update-people',
        canActivate:[permissionGuard],
        component:UpdatePeopleComponent,
      },
      {
        path:'my-timeline',
        canActivate:[permissionGuard],
        component:MyTimelineComponent,
      },
      {
        path:'setting',
        canActivate:[permissionGuard],
        component:SettingComponent,
      },
      {
        path:'contact-us',
        // canActivate:[permissionGuard],
        component:ContactUsComponent,
      },
      {
        path:'photo-and-stories',
        // canActivate:[permissionGuard],
        component:PhotoAndStoriesComponent,
      },
      {
        path:'how-works',
        // canActivate:[permissionGuard],
        component:HowItWorksComponent,
      },
      {
        path:'people',
        // canActivate:[permissionGuard],
        component:PeopleComponent,
      },
      {
        path:'my-people',
        // canActivate:[permissionGuard],
        component:MyPeopleComponent,
      },
      {
        path:'architect',
        // canActivate:[permissionGuard],
        component:ArchitectComponent,
      },
      {
        path:'',
        redirectTo:'screens/add-home',
        pathMatch:'full'
      }
    ],
  },
  {
    path:'',
    redirectTo:'screens/add-home',
    pathMatch:'full'
  },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class ScreensRoutingModule { }
