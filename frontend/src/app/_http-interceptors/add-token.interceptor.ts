import { Injectable } from '@angular/core';
import { HttpHandler, HttpRequest, HttpEvent, HttpHeaders, HttpInterceptor as HtppInterceptors } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AddTokenInterceptor implements HtppInterceptors {
  intercept(req: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {

    let token = localStorage.getItem('token');
    let headers = new HttpHeaders();

    if(token){
      headers = new HttpHeaders({
        'Authorization' : `Bearer ${token}`,
      });
    }
    const requestChange = req.clone({headers});
    return next.handle(requestChange);
  }
}
