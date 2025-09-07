import { Component } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { CapagiicService } from 'src/app/000_core/service/capagiic.service';

@Component({
  selector: 'app-social-login',
  templateUrl: './social-login.component.html',
  styleUrls: ['./social-login.component.scss'],
})
export class SocialLoginComponent {
  step: 'email' | 'password' | 'register' | 'code' | 'validate' | 'done' =
    'email';
  data: Array<any> | any;
  userEmail: string = '';
  userName: string = '';
  message: string = '';

  form = this.fb.group({
    email: ['renefgj@gmail.com', [Validators.required, Validators.email]],
    password: ['', Validators.required],
    fullname: ['Rene Faustino Gabriel Junior', Validators.required],
    code: ['243572', Validators.required],
  });

  // mock de "banco de usuários"
  mockUsers: string[] = ['teste@exemplo.com', 'user@site.com'];

  constructor(
    private fb: FormBuilder,
    private capagiicService: CapagiicService,
    private router: Router
  ) {}

  codeValidade() {
    let dt = {
      email: this.userEmail,
      code: this.form.value.code,
    };
    this.capagiicService.api_post('users/validate', dt).subscribe((res) => {
      console.log(res);
      this.data = res;
      this.message = this.data.message;
      if (this.data.status == '200') {
          this.router.navigate(['/questionary']);
        } else {
          this.message = 'Usuário não validado. Verifique seu email.';
          this.step = 'code';
          this.form.get('email')?.disable();
          this.form.get('fullname')?.disable();
      }
    });
  }

  // fluxo inicial
  checkEmail() {
    const email = this.form.value.email ?? '';
    if (!email) return;

    if (this.mockUsers.includes(email)) {
      this.step = 'password';
    } else {
      this.userEmail = email;
      this.capagiicService
        .api_post('users/exist', { email: email })
        .subscribe((res) => {
          console.log(res);
          this.data = res;
          this.message = this.data.message;
          if (this.data.status == '200') {
            if (this.data.validate == '1') {
              this.step = 'password';
            } else {
              this.message = 'Usuário não validado. Verifique seu email.';
              this.step = 'code';
              this.form.get('email')?.disable();
              this.form.get('fullname')?.disable();
            }
          } else {
            this.step = 'register';
            this.form.get('email')?.disable();
          }
        });
    }
  }

  ngOnInit() {
    this.form.get('email')?.enable();
    this.form.get('fullname')?.enable();
  }

  login() {
    if (this.form.value.password) {
      alert('Login realizado com sucesso!');
      this.step = 'done';
    }
  }

  register() {
    if (this.form.value.fullname) {
      let dt = {
        email: this.userEmail,
        fullname: this.form.value.fullname,
      };
      console.log(dt);
      // aqui você chamaria o serviço para registrar o usuário
      // simula envio de e-mail
      this.capagiicService.api_post('users/signup', dt).subscribe((res) => {
        console.log(res);
        this.data = res;
        this.message = this.data.message;
        if (this.data.status == '200') {
          //this.step = 'done';
        } else {
        }
      });
    }
  }
}
