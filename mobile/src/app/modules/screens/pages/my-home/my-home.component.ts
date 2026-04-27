import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ViewDidEnter } from '@ionic/angular';
import { addIcons } from 'ionicons';
import { ApiService } from 'src/app/core/services/api/http.service';
import { Listing } from 'src/app/core/services/api/models/api-response.model';
import { myHome } from 'src/app/shared/models/myhome.model';

@Component({
  selector: 'app-my-home',
  templateUrl: './my-home.component.html',
  styleUrls: ['./my-home.component.scss'],
})
export class MyHomeComponent implements OnInit, ViewDidEnter {
  public uid: any;
  public myHome: Listing[] = [];
  public isLoading = false;

  public constructor(public dataService: ApiService, public router: Router) {
    let user: any = localStorage.getItem('userData');
    user = JSON.parse(user);
    this.uid = user.id;
  }

  public ngOnInit(): void {
    addIcons({
      'add-home': 'assets/svg/add-home.svg',
    });
  }
  public ionViewDidEnter(): void {
    this.getMyHomes(true);
  }
  public getMyHomes(event: boolean): void {
    this.isLoading = true;
    this.dataService.myHome(this.uid).subscribe(
      (data) => {
        this.myHome = data.data.properties;
        this.isLoading = false;
      },
      (error) => {
        console.error('Error loading my homes:', error);
        this.isLoading = false;
      }
    );
  }
  public onClick(item: any): void {
    this.router.navigate(['/screens/view-detail', item.id]);
  }
  public addHome(): void {
    this.router.navigate(['/screens/add-home']);
  }
}
