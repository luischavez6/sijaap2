//inportaciones de scripts
importScripts('js/sw-utils.js');
//declaracion de constantes para util;izar en los tipos de cahce
const STATIC_CACHE='static-v1';
const DYNAMIC_CACHE='dynamic-v1';
const INMUTABLE_CACHE='inmutable-v1';
//elementos que se necesita guardar para ejecutar sin internet
const APP_SHELL=[
                '/',
                'index.html',
                'img/logo.jpeg',
                'pages/principal',
                'js/app.js',
                'js/jquery.min.js',
                'js/sw-utils.js'
                 ];
                
//crear elemnetos para el cache innmutable
const APP_SHELL_INMUTABLE=[
    'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css',
    'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js',
    'https://code.jquery.com/jquery-3.2.1.slim.min.js'

];
//Instalacion de un servir worker
self.addEventListener('install',e=>{
    //asignarle valor a una ocntante
    const cacheStatic=caches.open(STATIC_CACHE)
    .then(cache=>cache.addAll(APP_SHELL));
    const cacheInmutable=caches.open(INMUTABLE_CACHE)
    .then(cache=>cache.addAll(APP_SHELL_INMUTABLE));
    //ejecutar al mismo timepo
    e.waitUntil(Promise.all([cacheStatic,cacheInmutable]));
});
//evento activate eliminar caches viejas
//es caundo el nuevo services worker entre a controlar
self.addEventListener('activate',e=>{
    // caches.keys muestra todos los nombres y cuantas caches hay
    const respuesta=caches.keys()
    .then(keys=>{
        //verifica si exitse alguna cacahe con nombre static cache o que contenga nombre static y la elimina
        keys.forEach(key => {
            if(key!=STATIC_CACHE && key.includes('static')){
                return caches.delete(key);
            }
          
        });
      
  });
  e.waitUntil(respuesta);
});
self.addEventListener('fetch',e=>{
    //cache only solo busca recursos dentro de la cache
    const respuesta =caches.match(e.request).then(resp=>{
        if(resp){
            return resp;
        }else{
            //hacer un fetch que es hacer una solicitud
            return fetch(e.request)
            .then(newResp=>{
                return actualizaCacheDinamico(DYNAMIC_CACHE,e.request,newResp);
          });
            //console.log(e.request.url);
        }
    });
    e.respondWith(respuesta);
});