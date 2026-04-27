import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable, map } from 'rxjs';
import { environment } from 'src/environments/environment';
import {
  addHome,
  ForgetPasssword,
  Login,
  photosAndHistory,
  Signup,
} from './models/api-payload.model';
import {
  ApiResponse,
  DropdownParams,
  HomeListing,
  LoginResponse,
  NearbyListing,
  PropertyDetails,
  SignupResponse,
  UpdateProfileResponse,
  forgetPasswordResponse,
} from './models/api-response.model';
import { contact } from 'src/app/shared/models/contactUs.model';
import { People } from 'src/app/shared/models/people.model';
import { IApiResponse } from 'src/app/shared/models/api';
import { IHouse, ISimilarHouse } from 'src/app/shared/models/similar-house';

const BASE_URL = environment.baseUrl;

@Injectable({
  providedIn: 'root',
})
export class ApiService {
  public constructor(private http: HttpClient) {}

  public signup(user: any): Observable<SignupResponse> {
    return this.http
      .post<any>(`${BASE_URL}register`, JSON.stringify(user))
      .pipe(
        map((res: any) => {
          return res;
        })
      );
  }

  public login(user: Login): Observable<LoginResponse> {
    return this.http
      .post<LoginResponse>(`${BASE_URL}login`, JSON.stringify(user))
      .pipe(
        map((res: any) => {
          return res;
        })
      );
  }
  public forgetPassword(
    user: ForgetPasssword
  ): Observable<forgetPasswordResponse> {
    return this.http
      .post<forgetPasswordResponse>(
        `${BASE_URL}forgot_password`,
        JSON.stringify(user)
      )
      .pipe(
        map((res: any) => {
          return res;
        })
      );
  }
  public updateProfile(user: any): Observable<UpdateProfileResponse> {
    return this.http.post<any>(`${BASE_URL}profile`, JSON.stringify(user)).pipe(
      map((res: any) => {
        return res;
      })
    );
  }
  public updateProfileImage(user: any): Observable<any> {
    return this.http
      .post<any>(`${BASE_URL}user/update_profile_image`, JSON.stringify(user))
      .pipe(
        map((res: any) => {
          return res;
        })
      );
  }
  public updatehome(user: any): Observable<any> {
    return this.http
      .post<any>(`${BASE_URL}update_home`, JSON.stringify(user))
      .pipe(
        map((res: any) => {
          return res;
        })
      );
  }
  public updatePeople(user: any): Observable<any> {
    return this.http
      .post<any>(
        `${BASE_URL}home/update_people_to_property`,
        JSON.stringify(user)
      )
      .pipe(
        map((res: any) => {
          return res;
        })
      );
  }
  public updateStories(user: any): Observable<any> {
    return this.http
      .post<any>(
        `${BASE_URL}home/update_photo_story_to_property`,
        JSON.stringify(user)
      )
      .pipe(
        map((res: any) => {
          return res;
        })
      );
  }

  public homeListing(page: number): Observable<HomeListing> {
    return this.http.get<HomeListing>(`${BASE_URL}home/listings/${page}?`).pipe(
      map((res: HomeListing) => {
        return res;
      })
    );
  }
  public allHousesby(url: any): Observable<HomeListing> {
    return this.http.get<HomeListing>(`${BASE_URL}home/${url}`).pipe(
      map((res: HomeListing) => {
        return res;
      })
    );
  }

  public homeParams(): Observable<DropdownParams> {
    return this.http.get<DropdownParams>(`${BASE_URL}add_home/params`).pipe(
      map((res: DropdownParams) => {
        return res;
      })
    );
  }
  public homeDetailTimeline(masterId: any, userId: any): Observable<any> {
    return this.http
      .get<any>(`${BASE_URL}home/home_detail_timeline/${masterId}/${userId}`)
      .pipe(
        map((res: any) => {
          return res;
        })
      );
  }
  public photosAndHistorySimple(): Observable<any> {
    return this.http
      .get<photosAndHistory>(`${BASE_URL}home/photosnhistory`)
      .pipe(
        map((res: any) => {
          return res;
        })
      );
  }

  public nearbyListing(urlParam: any): Observable<NearbyListing> {
    return this.http.get<NearbyListing>(`${BASE_URL}${urlParam}`).pipe(
      map((res: NearbyListing) => {
        return res;
      })
    );
  }
  public myHome(home: any): Observable<any> {
    return this.http.get<any>(`${BASE_URL}user/my_homes/${home}`).pipe(
      map((res: any) => {
        return res;
      })
    );
  }
  public homeDetail(id: number): Observable<PropertyDetails> {
    return this.http.get<PropertyDetails>(`${BASE_URL}home/details/${id}`).pipe(
      map((res: any) => {
        return res.data;
      })
    );
  }
  public myTimeLine(timeLine: any): Observable<any> {
    return this.http.get<any>(`${BASE_URL}user/my_timeline/${timeLine}`).pipe(
      map((res: any) => {
        return res;
      })
    );
  }

  public photosAndHistory(url: string): Observable<any> {
    return this.http.get<photosAndHistory>(`${BASE_URL}home/${url}`).pipe(
      map((res: any) => {
        return res;
      })
    );
  }
  public peoplesby(url: number): Observable<any> {
    return this.http.get<People>(`${BASE_URL}home/${url}`).pipe(
      map((res: any) => {
        return res;
      })
    );
  }
  public peoples(): Observable<any> {
    return this.http.get<People>(`${BASE_URL}home/peoples`).pipe(
      map((res: any) => {
        return res;
      })
    );
  }

  public homeBanners(): Observable<any> {
    return this.http.get<People>(`${BASE_URL}home/banners`).pipe(
      map((res: any) => {
        return res;
      })
    );
  }

  public addHome(home: addHome): Observable<any> {
    return this.http.post<addHome>(`${BASE_URL}add_home`, home).pipe(
      map((res: any) => {
        return res;
      })
    );
  }
  public contactUs(contact: contact): Observable<any> {
    return this.http.post<contact>(`${BASE_URL}contactus`, contact).pipe(
      map((res: any) => {
        return res;
      })
    );
  }
  public livedHere(livedHere: any): Observable<any> {
    return this.http.post<any>(`${BASE_URL}home/i_lived_here`, livedHere).pipe(
      map((res: any) => {
        return res;
      })
    );
  }
  public addPeople(addPeople: any): Observable<any> {
    return this.http
      .post<any>(`${BASE_URL}home/add_people_to_property`, addPeople)
      .pipe(
        map((res: any) => {
          return res;
        })
      );
  }
  public addPhotoAndStory(addPhotoAndStory: any): Observable<any> {
    return this.http
      .post<any>(
        `${BASE_URL}home/add_photo_story_to_property`,
        addPhotoAndStory
      )
      .pipe(
        map((res: any) => {
          return res;
        })
      );
  }
  public monitorHome(monitorHome: any): Observable<any> {
    return this.http
      .post<any>(`${BASE_URL}home/monitor_home`, monitorHome)
      .pipe(
        map((res: any) => {
          return res;
        })
      );
  }
  public stopMonitorHome(id: number): Observable<any> {
    return this.http
      .get<any>(`${BASE_URL}home/turn-off-notification/${id}`)
      .pipe(
        map((res: any) => {
          return res;
        })
      );
  }
  public termsAndConditions(): Observable<any> {
    return this.http.get<any>(`${BASE_URL}pages/termandconditions`).pipe(
      map((res: any) => {
        return res;
      })
    );
  }
  public submitTrademark(payload:any): Observable<any> {
    return this.http.post<any>(`${BASE_URL}submit_trademark`, payload).pipe(
      map((res: any) => {
        return res;
      })
    );
  }
  public similarHouse(street: string): Observable<IApiResponse<ISimilarHouse>> {
    return this.http
      .get<IApiResponse<ISimilarHouse>>(
        `${BASE_URL}home/houses/1?street=${street}`
      )
      .pipe(
        map((res: IApiResponse<ISimilarHouse>) => {
          return res;
        })
      );
  }
}
