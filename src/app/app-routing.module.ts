import { NgModule } from '@angular/core';
import { PreloadAllModules, RouterModule, Routes } from '@angular/router';
import { LoginGuard } from './guards/auth.guard';
import { VerifiGuard } from './guards/auth.guard';
import { RepartidorGuard } from './guards/auth.guard';

const routes: Routes = [
  {path: 'login',loadChildren: () => import('./login/login.module').then(m => m.LoginPageModule)},
  {path: '',redirectTo: 'login',pathMatch: 'full'},
  {path: 'cliente',loadChildren: () => import('./cliente/cliente.module').then(m => m.ClientePageModule),canActivate: [LoginGuard]},
  {path: 'registro',loadChildren:() => import('./registro/registro.module').then(m=> m.RegistroPageModule)},
  {path: 'verificar',loadChildren:() => import('./verificar/verificar.module').then(m=> m.VerificarPageModule), canActivate: [VerifiGuard]},
  {path: 'repartidor',loadChildren:() => import('./repartidor/repartidor.module').then(m=> m.RepartidorPageModule),canActivate: [RepartidorGuard]},
];

@NgModule({
  imports: [
    RouterModule.forRoot(routes, { preloadingStrategy: PreloadAllModules })
  ],
  exports: [RouterModule]
})
export class AppRoutingModule { }
