import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router, NavigationExtras } from '@angular/router';
import { categorias } from './categorias';
import { AuthService } from '../../auth.service';
import { AlertController } from '@ionic/angular';

@Component({
  selector: 'app-pedido',
  templateUrl: './pedido.page.html',
  styleUrls: ['./pedido.page.scss'],
})
export class PedidoPage implements OnInit {
  mensaje: string = '';
  id: number = 0;
  cat: string = '';
  direcciones: any[] = [];
  categorias = categorias;
  subcategorias: string[] = [];
  pedidoTexto: string = '';
  categoria: string = '';
  subcategoria: string = '';
  pedidoTexto1: string = '';
  direccion: string = '';
  nombre: string = '';

  constructor(private route: ActivatedRoute, 
    private router: Router, 
    private authService: AuthService,
    private alertController: AlertController) {}

  ngOnInit() {
    this.id = parseInt(sessionStorage.getItem('key_cliente') || '0', 10);
    const categoriaFromSession = localStorage.getItem('categoria');
      if (categoriaFromSession !== null) {
          this.cat = categoriaFromSession;
      } else {
          this.cat = '';
      }
    const hora = new Date().getHours();
    if (hora >= 0 && hora < 12) {
      this.mensaje = 'Buenos Días';
    } else if (hora >= 12 && hora < 18) {
      this.mensaje = 'Buenas Tardes';
    } else {
      this.mensaje = 'Buenas Noches';
    }
    this.obtener();
    this.filtrarSubcategorias();
    this.name();
  }
  name() {
    this.authService.name(this.id).subscribe(
      (response)=> {
        this.nombre = response;
      },(Error) => {
        console.log('Error', Error);}
    );
  }

  obtener() {
    this.authService.obtdire(this.id).subscribe(
      (data: string[]) => {
        this.direcciones = data;
      },
      (error) => {
        console.error('Error al obtener direcciones:', error);
      }
    );
  }
  obdire() {
    this.authService.obtrp(this.id).subscribe(
      (data: any[]) => {
        this.direcciones = data;
      },
      (error) => {
        console.error('Error al obtener direcciones:', error);
      }
    );
  }

  filtrarSubcategorias() {
    const categoriaEncontrada = this.categorias.find(c => c.nombre === this.cat);
    if (categoriaEncontrada) {
      this.subcategorias = categoriaEncontrada.subcategorias;
    }
  }

  enviarFormulario() {
    if (this.cat && this.subcategoria && this.pedidoTexto1 && this.direccion) {
      const datos = {
        id: this.id,
        cat: this.cat,
        subcategoria: this.subcategoria,
        pedidoTexto1: this.pedidoTexto1,
        direccion: this.direccion,
      };
      this.authService.addpedido(datos).subscribe(
        (respuesta) => {
          console.log('Respuesta del servidor:', respuesta);
          this.home();
        },
        (error) => {
          console.error('Error al enviar el pedido:', error);
        }
      );
    }
  }

  //botones
  us() {
    localStorage.clear();
    this.router.navigate(['cliente/perfil']);
  }
  ped() {
    localStorage.clear();
    this.router.navigate(['cliente/his-pedi']);
  }
  home(){
    localStorage.clear();
    this.router.navigate(['cliente']);
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
                  sessionStorage.clear();
                  localStorage.clear();
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
