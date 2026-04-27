import { Component, Input, OnInit } from '@angular/core';
import {
  ModalController,
  ModalOptions,
  RangeChangeEventDetail,
} from '@ionic/angular';
import { RangeCustomEvent } from '@ionic/angular';

import { FilterArray } from '../../models/filter.model';
import { ParamsData } from 'src/app/core/services/api/models/api-response.model';
@Component({
  selector: 'app-filter-modal',
  templateUrl: './filter-modal.component.html',
  styleUrls: ['./filter-modal.component.scss'],
})
export class FilterModalComponent implements OnInit {
  @Input() public params!: ParamsData;
  @Input() public type:string = '';
  public filterArray: FilterArray = {
    state: '',
    houseStyle: '',
    bedroom: '',
    yearBuilt: '',
    material: '',
    foundation: '',
    roofType: '',
    sqFt: '',
    street: '',
    city: '',
    country: '',
    nearBy: '',
    zipCode: '',
    ownerName: '',
    rangeYearBuilt: { lower: '1600', upper: '2024' },
    rangeSquareFeet: { lower: '', upper: '' },
    rangeMile: { lower: '0', upper: '50' },
    nrhp: false,
  };
  public constructor(private modalCtrl: ModalController) {}

  public ngOnInit(): void {}
  public pinFormatter(value: number): string {
    return `${value}%`;
  }
  public yearRangeChange(ev: Event) {
    const value: any = (ev as RangeCustomEvent).detail.value;
    this.filterArray.rangeYearBuilt = value;
  }
  public sqFtRangeChange(ev: Event) {
    const value: any = (ev as RangeCustomEvent).detail.value;
    this.filterArray.rangeSquareFeet = value;
  }
  public mileRangeChange(ev: Event) {
    const value: any = (ev as RangeCustomEvent).detail.value;
    this.filterArray.rangeMile = value;
  }
  public cancel(): any {
    return this.modalCtrl.dismiss(null, 'cancel');
  }

  public confirm(): any {
    return this.modalCtrl.dismiss(this.filterArray, 'confirm');
  }
  public onSelectableChange(event: any, type: string): void {
    if (type === 'material') {
      this.filterArray.material = event;
    }
    if (type === 'roof') {
      this.filterArray.roofType = event;
    }
    if (type === 'foundation') {
      this.filterArray.foundation = event;
    }
    if (type === 'house_style') {
      this.filterArray.houseStyle = event;
    }
    if (type === 'state') {
      this.filterArray.state = event;
    }
  }
}
