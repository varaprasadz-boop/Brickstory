import { Component } from '@angular/core';

@Component({
  selector: 'app-card-skeleton',
  templateUrl: './card-skeleton.component.html',
  styleUrls: ['./card-skeleton.component.scss'],
})
export class CardSkeletonComponent {
  // Array to create multiple skeleton items
  public skeletonItems = Array(6).fill(0);
}
