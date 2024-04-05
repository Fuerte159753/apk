import { inject } from "@angular/core";
import { Router } from "@angular/router";

export const LoginGuard = () => {
  const router = inject(Router)
  
  if (sessionStorage.getItem('key_cliente')) {
    return true;
  }else{
    router.navigate(['/login']);
    return false;
  }
}
export const RepartidorGuard = () => {
  const router = inject(Router)
  
  if (sessionStorage.getItem('key_repartidor')) {
    return true;
  }else{
    router.navigate(['/login']);
    return false;
  }
}
export const VerifiGuard = () => {
  const router = inject(Router)
  
  if (sessionStorage.getItem('key_c_verifi')) {
    return true;
  }else{
    router.navigate(['/login']);
    return false;
  }
}