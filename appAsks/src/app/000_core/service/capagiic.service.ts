import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class CapagiicService {
  http: any;
  constructor(
    private HttpClient: HttpClient
  ) //private cookieService: CookieService
  {}

  //private url: string = 'http://find/v2/api/';
  private url: string = 'http://capagiic/api/';
  //private url: string = 'https://www.ufrgs.br/find/v2/api/';

  public api_post(
    type: string,
    dt: Record<string, any> = {},
    development: boolean = false
  ): Observable<Array<any>> {
    let url = `${this.url}` + type;
    console.log("APIPOST",url);
    var formData: any = new FormData();
    //let apikey = this.cookieService.get('section');
    //formData.append('user', apikey);
    //formData.append('library', library);

    for (const key in dt) {
      formData.append(key, dt[key]);
    }

    return this.HttpClient.post<Array<any>>(url, formData).pipe(
      (res) => res,
      (error) => error
    );
  }
}
