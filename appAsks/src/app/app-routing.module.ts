import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { SocialLoginComponent } from './020_login/social-login/social-login.component';
import { StartpageComponent } from './000_core/startpage/startpage.component';
import { QuestionaryComponent } from './010_question/questionary/questionary.component';
import { PlaceListComponent } from './030_place/place-list/place-list.component';

const routes: Routes = [
  { path: '', component: StartpageComponent },
  { path: 'login', component: SocialLoginComponent },
  { path: 'place', component: PlaceListComponent },
  { path: 'questionary', component: QuestionaryComponent },
  { path: '**', redirectTo: '' },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
