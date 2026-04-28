import { Component, OnInit, inject } from '@angular/core';
import { Router } from '@angular/router';
import { MenuController } from '@ionic/angular';
import { Menu } from '../../models/menu.model';
import { StorageService } from 'src/app/core/services/storage/storage.service';

@Component({
  selector: 'app-menu',
  templateUrl: './menu.component.html',
  styleUrls: ['./menu.component.scss'],
})
export class MenuComponent implements OnInit {
  public menu: Menu[] = [
    { name: 'Add a Home', path: '/screens/add-home' },
    { name: 'Near Me', path: '/tabs/location' },
    { name: 'Houses', path: '/screens/all-house' },
    { name: 'Photos & Stories', path: '/screens/photo-and-stories' },
    { name: 'People', path: '/screens/people' },
    { name: 'Architects', path: '/screens/architect' },
    { name: 'Contact Us', path: '/screens/contact-us' },
    { name: 'About Us', path: '/screens/about' },
    { name: 'How it Works', path: '/screens/how-works' },
  ];
  private localStorage = inject(StorageService);
  public isLoggedIn :boolean = this.localStorage.isLoggedIn();
  public constructor(
    public router: Router,
    public menuController: MenuController
  ) {}

  public ngOnInit(): void {}

  public goTo(path: string): void {
    this.router.navigate([path]).then((res) => {
      this.menuController.close();
    });
  }
  public menuEvent():void {
    this.isLoggedIn = this.localStorage.isLoggedIn() ? true : false;
  }
  public isAuthenticated(): void {
    if (this.isLoggedIn) {
      this.localStorage.logout();
      this.isLoggedIn = false;
      this.menuController.close();
      this.router.navigate(['/auth/login']);
    } else {
      this.router.navigate(['/auth/login']).then(() => {
        this.menuController.close();
      });
    }
  }
}
