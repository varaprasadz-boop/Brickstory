import { NgModule } from '@angular/core';
import { CommonModule, DatePipe } from '@angular/common';
import { ScreensRoutingModule } from './screens-routing.module';
import { AboutBrickComponent } from './pages/about-brick/about-brick.component';
import { FormsModule } from '@angular/forms';
import { RouteReuseStrategy } from '@angular/router';
import { IonicModule, IonicRouteStrategy } from '@ionic/angular';
import { AuthRoutingModule } from '../auth/auth-routing.module';
import { AddHomeComponent } from './pages/add-home/add-home.component';
import { ViewDetailComponent } from './pages/view-detail/view-detail.component';
import { MyHomeComponent } from './pages/my-home/my-home.component';
import { UpdateProfileComponent } from './pages/update-profile/update-profile.component';
import { MyTimelineComponent } from './pages/my-timeline/my-timeline.component';
import { SettingComponent } from './pages/setting/setting.component';
import { ContactUsComponent } from './pages/contact-us/contact-us.component';
import { PeopleComponent } from './pages/people/people.component';
import { ArchitectComponent } from './pages/architect/architect.component';
import { HowItWorksComponent } from './pages/how-it-works/how-it-works.component';
import { PhotoAndStoriesComponent } from './pages/photo-and-stories/photo-and-stories.component';
import { SharedModule } from 'src/app/shared/shared.module';
import { ViewPhotosComponent } from './pages/view-photos/view-photos.component';
import { IonicSelectableComponent } from 'ionic-selectable';
import { AddStoryComponent } from 'src/app/shared/components/add-story/add-story.component';
import { ParamResolver } from 'src/app/core/resolvers/param.resolver.service';
import { ReactiveFormsModule } from '@angular/forms';
import { UpdateHomeComponent } from './pages/update-home/update-home.component';
import { MyPeopleComponent } from './pages/my-people/my-people.component';
import { UpdatePeopleComponent } from './pages/update-people/update-people.component';
import { MyStoriesComponent } from './pages/my-stories/my-stories.component';
import { UpdateStoriesComponent } from './pages/update-stories/update-stories.component';
import { AllHouseComponent } from './pages/all-house/all-house.component';
import { AutoCompletePage } from './pages/add-home/components/auto-complete.page';
import { SimilarHouseModalComponent } from './pages/add-home/components/similar-house-modal.component';
import { FormInput } from 'src/app/shared/components/form-input/form-input.component';
import { ReversePipe } from 'src/app/core/pipes/reverse.pipe';
@NgModule({
  declarations: [
    AllHouseComponent,
    AboutBrickComponent,
    AddHomeComponent,
    ViewDetailComponent,
    MyHomeComponent,
    UpdateProfileComponent,
    MyTimelineComponent,
    SettingComponent,
    ContactUsComponent,
    PeopleComponent,
    ArchitectComponent,
    HowItWorksComponent,
    PhotoAndStoriesComponent,
    ViewPhotosComponent,
    AddStoryComponent,
    UpdateHomeComponent,
    MyPeopleComponent,
    UpdatePeopleComponent,
    MyStoriesComponent,
    UpdateStoriesComponent,
    AutoCompletePage,
    SimilarHouseModalComponent,
    FormInput,
    ReversePipe
  ],
  imports: [
    FormsModule,
    CommonModule,
    ScreensRoutingModule,
    ReactiveFormsModule,
    AuthRoutingModule,
    IonicModule.forRoot(),
    AuthRoutingModule,
    SharedModule,
    IonicSelectableComponent,
  ],
  providers: [
    { provide: RouteReuseStrategy, useClass: IonicRouteStrategy },
    ParamResolver,
    DatePipe,
    ViewDetailComponent,
  ],
})
export class ScreensModule {}
