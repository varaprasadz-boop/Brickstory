import { Component, OnInit } from '@angular/core';
import { ViewDidEnter } from '@ionic/angular'; 

@Component({
  selector: 'app-notifications',
  templateUrl: './notifications.component.html',
  styleUrls: ['./notifications.component.scss'],
})
export class NotificationsComponent  implements OnInit {
  public deliveredNotifications: any[] = [];
  public constructor() { }

  public ngOnInit() {}
}
