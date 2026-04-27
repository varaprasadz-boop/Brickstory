import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'datepicker',
  template: `
    <ion-datetime-button datetime="datetime" mode="ios"></ion-datetime-button>

    <ion-modal [keepContentsMounted]="true" mode="ios" [showBackdrop]="true">
      <ng-template>
        <ion-datetime
          id="datetime"
          presentation="date"
          value="2023-11-02T01:22:00"
          [showDefaultButtons]="true"
          [formatOptions]="{
        date: {
          weekday: 'short',
          month: 'long',
          day: '2-digit',
        },
      }"
        ></ion-datetime>
      </ng-template>
    </ion-modal>
  `,
  styles: `
  ion-backdrop {
    opacity: 0.9;
    background: var(--ion-color-primary);
    }
  `,
})
export class DatePicker implements OnInit {
  public constructor() {}

  public ngOnInit(): void {}
}
