import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { BehaviorSubject } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  private isLoggedInSubject = new BehaviorSubject<boolean>(false);
  isLoggedIn$ = this.isLoggedInSubject.asObservable();

  constructor(private http: HttpClient) { }
  //url = 'https://mandaditos.proyectoinutvm.com/';
  //url2 = 'https://mandaditos.proyectoinutvm.com/repartidor/';
  url = 'http://localhost/mandaditos/';
  url2 = 'http://localhost/mandaditos/repartidor/';
  
                      ///////////cliente\\\\\\\\\\\\\\\\
  login(email: string, password: string) {
    return this.http.post<any>(this.url + 'login.php', { email, password });
  }
  name(id: number) {
    return this.http.get<string>(`${this.url}name.php?id=${id}`);
  }
  per(id:number){
    return this.http.post<any>(this.url + 'perfil.php', { id });
  }
  reg(registroData: any){
    return this.http.post<any>(this.url + 'registro.php', {registroData});
  }
  udp(id: number, newData: any){
    return this.http.post<any>(this.url+'editar_p.php', { id, newData });
  }
  in(id: number, nd:string){
    return this.http.post(this.url+'agregar_direccion.php',{id, nd});
  }
  obtr(id: number){
    return this.http.post<any[]>(this.url+'ob_dire.php',{ id });
  }
  elimidire(idre:number){
    return this.http.post(this.url+'elimi_dire.php',{idre})
  }
  verifi(id:number, codigo:string){
    return this.http.post<any>(this.url+'verificar.php',{id, codigo})
  }
  obtdire(id:number){
    return this.http.post<any[]>(this.url+'ob_dire.php',{id})
  }
  addpedido(datos: any){
    return this.http.post<any>(this.url + 'regpedido.php', {datos});
  }
  obpedi(id:number){
    return this.http.post<any[]>(this.url+'ob_pedidos.php',{id});
  }
  obtrp(id:number){
    return this.http.post<any[]>(this.url+'ob_dire.php',{ id });
  }
  eliminarped(pedidoId: string) {
    const formData = new FormData();
    formData.append('pedido_id', pedidoId);
    return this.http.post<any>(this.url + 'cancelar_pedido.php', formData);
  }  
                          ////////REPARTIDOR\\\\\\\\\\\\\
  obrepa(id:string){
    return this.http.post<any[]>(this.url2+'obtener_ped.php',{id}); 
  }
  cambio_entre(pedidoId: number) {
    return this.http.post<any>(this.url2 + 'cambio_entre.php', { pedidoId });
  }
}
