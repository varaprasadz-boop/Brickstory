import { Component, OnInit } from '@angular/core';
import { ApiService } from 'src/app/core/services/api/http.service';
import { photosAndHistory } from 'src/app/core/services/api/models/api-payload.model';

@Component({
  selector: 'app-my-stories',
  templateUrl: './my-stories.component.html',
  styleUrls: ['./my-stories.component.scss'],
})
export class MyStoriesComponent  implements OnInit {
  public photosAndStories:photosAndHistory[]=[];
  
  public constructor(public dataService:ApiService) {}

  public ngOnInit() {
   this.getphotosAndStories()
  }

  public getphotosAndStories(): void {
    let user:any=localStorage.getItem('userData');
    user = JSON.parse(user).id;
    this.dataService.photosAndHistorySimple().subscribe(data => { 
    this.photosAndStories = data.data.result.filter((person:any) => person.user_id === user) ;
    console.log(this.photosAndStories);
  })
  }
}