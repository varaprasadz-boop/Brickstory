import { Component } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-tabs',
  templateUrl: 'tabs.page.html',
  styleUrls: ['tabs.page.scss'],
})
export class TabsPage {
  public constructor(public router: Router) {}

  public addHome(): void {
    this.router.navigateByUrl('/screens/add-home');
  }
  public location(): void {
    this.router.navigate(['/tabs/location']);
  }
}
