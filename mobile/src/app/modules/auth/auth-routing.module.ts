import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { LoginComponent } from './login/login.component';
import { SignupComponent } from './signup/signup.component';
import { SplashScreenComponent } from './splash-screen/splash-screen.component';
import { ForgetPasswordComponent } from './forget-password/forget-password.component';
const routes: Routes = [
  {
    path:'auth',
    children:[
      {
        path:'login',
        component:LoginComponent
      },
      {
        path:'signup',
        component:SignupComponent
      },
      {
        path:'forget-password',
        component:ForgetPasswordComponent
      },
      {
        path:'intro',
        component:SplashScreenComponent
      },
      {
        path:'',
        redirectTo:'auth/intro',
        pathMatch:'full'
      }
    ],
  },
  {
    path:'',
    redirectTo:'auth/intro',
    pathMatch:'full'
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class AuthRoutingModule { }
