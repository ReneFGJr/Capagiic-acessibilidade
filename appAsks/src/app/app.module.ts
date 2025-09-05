import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { NavbarComponent } from './000_core/navbar/navbar.component';
import { HeaderComponent } from './000_core/header/header.component';
import { FooterComponent } from './000_core/footer/footer.component';
import { QuestionType01Component } from './010_question/question-type01/question-type01.component';
import { ThemaComponent } from './010_question/thema/thema.component';
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';

@NgModule({
  declarations: [
    AppComponent,
    NavbarComponent,
    HeaderComponent,
    FooterComponent,
    QuestionType01Component,
    ThemaComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    NgbModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
