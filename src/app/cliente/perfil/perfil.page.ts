import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router, NavigationExtras } from '@angular/router';
import { AuthService } from 'src/app/auth.service';
import { Camera, CameraResultType } from '@capacitor/camera';
import { AlertController } from '@ionic/angular';
@Component({
  selector: 'app-perfil',
  templateUrl: './perfil.page.html',
  styleUrls: ['./perfil.page.scss'],
})
export class PerfilPage implements OnInit {
  mensaje: string='';
  id: number=0;
  cl: any = {};

  constructor(private router: Router, 
    private route: ActivatedRoute, 
    private authService: AuthService,
    private alertController: AlertController) { }

  ngOnInit() {
    this.id = parseInt(sessionStorage.getItem('key_cliente') || '0', 10);
    this.oc()
  }
  us() {
    this.router.navigate(['cliente/perfil']);
  }
  oc() {
    this.authService.per(this.id).subscribe(
      response => {this.cl = response;},
      error => {console.error('Error al obtener el perfil del cliente:', error);});
  }
  
  edit() {
    this.router.navigate(['cliente/edit-p']);
  }
  ped() {
    this.router.navigate(['cliente/his-pedi']);
  }
  home(){
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

  async takePhoto() {
    try {
      const capturedPhoto = await Camera.getPhoto({
        quality: 90,
        allowEditing: false,
        resultType: CameraResultType.Uri
      });
      
      // Genera un nombre aleatorio para la imagen
      const imageName = this.generateRandomName();
      
      // Guarda la imagen en la carpeta de activos (src/assets) con el nombre aleatorio
      const savedImageFile = await this.saveImageToAssets(capturedPhoto, imageName);

      // Guarda la ubicación de la imagen junto con el nombre en la base de datos usando tu servicio AuthService
      //this.authService.guardarImagen(savedImageFile.webPath, imageName);

      // Actualiza la URL de la imagen en la vista
      this.cl.avatarUrl = savedImageFile.webPath;
    } catch (error) {
      console.error('Error al capturar la foto:', error);
    }
  }

  async saveImageToAssets(capturedPhoto: any, imageName: string) {
    // Lógica para guardar la imagen en la carpeta de activos
    return capturedPhoto; // Devuelve el archivo guardado
  }

  generateRandomName(): string {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let result = '';
    for (let i = 0; i < 10; i++) {
      result += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    return result;
  }

}
