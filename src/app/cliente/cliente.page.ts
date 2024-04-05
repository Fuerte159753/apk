import { AuthService } from 'src/app/auth.service';
import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router, NavigationExtras } from '@angular/router';
import { AlertController } from '@ionic/angular';

@Component({
  selector: 'app-cliente',
  templateUrl: './cliente.page.html',
  styleUrls: ['./cliente.page.scss'],
})
export class ClientePage implements OnInit {
  mensaje: string = '';
  id: number = 0;
  nombre: string = '';

  constructor(private route: ActivatedRoute, 
    private router: Router,
    private authservice:AuthService,
    private alertController: AlertController) {}

  ngOnInit() {
    this.id = parseInt(sessionStorage.getItem('key_cliente') || '0', 10);
    const hora = new Date().getHours();
    if (hora >= 0 && hora < 12) {
      this.mensaje = 'Buenos Días';
    } else if (hora >= 12 && hora < 18) {
      this.mensaje = 'Buenas Tardes';
    } else {
      this.mensaje = 'Buenas Noches';
    }
    
    this.name();
  }
  name() {
    this.authservice.name(this.id).subscribe(
      (response)=> {
        this.nombre = response;
      },(Error) => {
        console.log('Error', Error);}
    );
  }
  orden(categoria: string){
    localStorage.setItem('categoria', categoria);
    this.router.navigate(['cliente/pedido']);
  }

  //botones
  us() {
    this.router.navigate(['cliente/perfil']);
  }
  ped() {
    this.router.navigate(['cliente/his-pedi']);
  }
  async logout() {
    const alert = await this.alertController.create({
        header: 'Cerrar sesión',
        message: '¿Estás seguro de que deseas cerrar sesión?',
        buttons: [
            {
                text: 'Cancelar',
                role: 'cancel',
                cssClass: 'secondary',
                handler: () => {
                    console.log('Operación cancelada');
                }
            }, {
                text: 'Sí',
                handler: () => {
                  sessionStorage.clear()
                    this.router.navigate(['/login']);
                }
            }
        ]
    });

    await alert.present();
}
  isTabActive(tab: string): boolean {
    return this.router.url.includes(tab);
  }
}
