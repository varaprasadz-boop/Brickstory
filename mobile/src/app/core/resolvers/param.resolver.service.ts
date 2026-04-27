import { Injectable } from '@angular/core';
import { Resolve, ActivatedRouteSnapshot, Router } from '@angular/router';
import { Observable } from 'rxjs';
import { map, catchError } from 'rxjs/operators';
import { ApiService } from '../services/api/http.service';
import { ParamsData } from '../services/api/models/api-response.model';

@Injectable({
  providedIn: 'root'
})
export class ParamResolver implements Resolve<ParamsData> {

  public constructor(
    private router: Router,
    private api: ApiService
  ) {}

  public resolve(route: ActivatedRouteSnapshot): Observable<ParamsData> {
    console.log('Resolving route:', route.routeConfig?.path);
    return this.api.homeParams().pipe(
      map((params: any) => { 
        if (!params) {
          console.error('Params not found');
          this.router.navigate(['/error']);
          return null;
        }
        return params.data;
      }),
      catchError((error) => {
        console.error('Error fetching params', error);
        this.router.navigate(['/error']);
        return [];
      })
    );
  }
  
}
