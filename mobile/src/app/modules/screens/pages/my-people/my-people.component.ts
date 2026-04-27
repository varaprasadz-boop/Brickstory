import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ModalController } from '@ionic/angular';
import { ApiService } from 'src/app/core/services/api/http.service';
import { People } from 'src/app/shared/models/people.model';
import { UpdatePeopleComponent } from '../update-people/update-people.component';

@Component({
  selector: 'app-my-people',
  templateUrl: './my-people.component.html',
  styleUrls: ['./my-people.component.scss'],
})
export class MyPeopleComponent implements OnInit {
  public people: People[] = [];
  public constructor(
    public dataService: ApiService,
    public router: Router,
    private modalCtrl: ModalController
  ) {}

  public ngOnInit(): void {
    this.getPeople();
  }

  public getPeople(): void {
    let userId: any = localStorage.getItem('userData');
    userId = JSON.parse(userId).id;
    this.dataService.peoples().subscribe((response) => {
      this.people = response.data.peoples.filter(
        (person: any) => person.user_id === userId
      );
    });
  }
  public async updatePeople(item: any): Promise<void> {
    const modal = await this.modalCtrl.create({
      component: UpdatePeopleComponent,
      componentProps: {
        peopleDetail: item,
      },
    });
    modal.present();
  }
  public homeDetails(id: string): void {
    this.router.navigate(['/screens/view-detail', id]);
  }
}
