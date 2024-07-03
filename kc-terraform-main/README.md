## :sparkler: <u>Firewall Force - Project</u>
<strong>Developed by:</strong></br>
Jhonny Alexander Gómez</br>
Anades Pacheco</br>
Sergi Castillo</br>
Juan Andrés Esparragoso</br>
<div align="center">
    <img src="/images/header.png?raw=true" alt="Propuesta Inical" width="400px" />
</div>

# :star: Quick Reference:
https://github.com/FirewallForce/kc-proyecto-final-devops 

----

~~~
- Mail: firewallforce@gmail.com
- Web: https://jhonalex.com/
~~~
----

## :sparkler: <u>Datos del proyecto.</u>
Esta infraestructura se desplego en la nube de AWS en la cuenta:<strong>Training_Anades 156726536920</strong>.</br>
<strong>Terraform IaC:</strong> Se está utilizando Terraform como una herramienta de Infraestructura como Código (IaC) para provisionar y gestionar infraestructuras. Terraform permite a los usuarios definir y crear infraestructura completa en AWS de manera declarativa.</br>
	<strong>Comandos de Terraform:</strong> Se mencionan tres comandos básicos de Terraform:</br>
    <strong>plan:</strong> Se utiliza para crear un plan de ejecución, que muestra lo que Terraform planea hacer antes de que se hagan cambios reales en la infraestructura.</br>
    <strong>apply:</strong> Aplica los cambios definidos en Terraform para alcanzar el estado deseado de la infraestructura.</br>
    <strong>destroy:</strong> Elimina la infraestructura gestionada por Terraform, deshaciendo los cambios aplicados.</br>
    <strong>WebSite – EndPoint:</strong> Está sirviendo una aplicación web, la cual es accesible para los usuarios finales a través de un endpoint, como lo es la url del del apache, resolviendo un registro A del DNS:34.255.109.246.</br>

----

## :sparkler: <u>Recursos Desplegados a nivel de Red </u>	
<strong>Network VPC (Virtual Private Cloud):</strong>Este bloque define una VPC con un bloque CIDR de 10.0.0.0/16, proporcionando un espacio de direcciones privadas grande dentro del cual puedes colocar subredes y otros recursos de red.</br>
<strong>Subnet:</strong>Este bloque configura una subred dentro de la VPC creada anteriormente. Usa un bloque CIDR más específico (10.0.0.0/24) y está localizada en la zona de disponibilidad eu-west-1a. La opción map_public_ip_on_launch = true indica que las instancias lanzadas en esta subred recibirán automáticamente una dirección IP pública.</br>
<strong>Security Group:</strong> Este bloque crea un grupo de seguridad dentro de la VPC que permite tráfico saliente hacia cualquier destino y tráfico entrante en los puertos 22 (SSH), 80 (HTTP), y 443 (HTTPS) desde cualquier lugar.</br>
<strong>Internet Gateway:</strong>Define una puerta de enlace de internet (Internet Gateway) y la asocia con la VPC. Esta puerta de enlace permite la comunicación entre la VPC y el internet.</br>
<strong>Route Table y Route Table AssociationEstos:</strong> bloques configuran una tabla de enrutamiento que define una ruta por defecto hacia el Internet Gateway para el tráfico destinado a direcciones fuera de la VPC. Además, asocia esta tabla de enrutamiento con la subred creada anteriormente, efectivamente convirtiéndola en una subred pública.</br>

----

## :sparkler: <u>Recursos Desplegados a nivel de EC2</u>	
<strong>Key Pair para SSH:</strong>Este bloque crea un par de claves en AWS, donde key_name es el nombre asignado al par de claves, y public_key carga el contenido de tu clave pública SSH desde tu máquina local. Esto permite el acceso SSH seguro a las instancias EC2 creadas en AWS que utilicen este par de claves.</br>
<strong>Instancia EC2 con Apache</strong>Este bloque define una instancia EC2 que utilizará una AMI específica (que debe ser relevante para la región en la que estás trabajando) y será del tipo t2.medium. La instancia usará el par de claves SSH creado, estará ubicada en la subred y grupo de seguridad especificados. El bloque user_data contiene un script que se ejecuta en el primer inicio de la instancia para:
     Actualizar los paquetes del sistema.</br>
     Instalar y configurar el servidor web Apache.</br>
     Instalar Certbot y configurar una prueba de renovación automática de certificados SSL, lo cual es útil para configurar HTTPS.</br>
<strong>Dirección IP Pública Estática (Elastic IP):</strong>Este bloque crea y asigna una dirección IP pública estática (Elastic IP) a la instancia EC2. Esto garantiza que la dirección IP de la instancia no cambiará a través de reinicios de la máquina, lo cual es importante para el acceso a través de Internet y para servicios que dependen de la IP.</br>

----
### :sparkler: <u>Como desplegar la infraestructura</u>
#### <u>Mediante Terraform</u>
Partimos de que debe tener instalado Terraform y Visual Studio Code.

Si no esta instalado deberá realizar las instalaciones adecuadas:
[Descarga e instalación de Terraform](https://developer.hashicorp.com/terraform/install)
<br/>
[Descarga e instalación de Visual Studio Code](https://code.visualstudio.com/download)

----
### :sparkler: <u>Ejecución en Windows</u>
Accedemos a la carpeta de nuestro PC local donde
deseemos mantener el proyecto y Clonamos el repositorio
~~~
cd C:\
 git clone https://github.com/FirewallForce/kc-terraform 
~~~

Inicializar los proveedores y todo lo necesario para la ejecución de terraform.
~~~
terraform init
~~~

Para poder observar que acciones llevará a cabo terraform.
~~~
terraform plan
~~~

Para que se ejecute el plan anterior y no pida confirmación.
~~~
terraform apply -auto-approve
~~~

Finalmente destruimos la infraestructura para evitar costes innecesarios, evitando confirmación.
~~~
terraform destroy -auto-approve
~~~

----

### :sparkler: <u>Output</u>
<strong> Esta es la URL del proyecto.</strong> </br>
Outputs:
"https://jhonalex.com/"

----

## :sparkler:<u>Funciones de Monitoreo y Gestión</u>
<strong>Uso de CPU (% de utilización):</strong>Muestra picos de actividad, indicando posiblemente la ejecución de tareas que consumen recursos o el tráfico a la instancia.</br>
<strong>Tráfico de Red (Network In/Out en bytes):</strong> Indica la cantidad de datos entrantes y salientes, útil para entender la cantidad de tráfico que maneja la instancia.</br>
<strong>Paquetes de Red (Network packets in/out count):</strong> Número de paquetes enviados y recibidos, que da una idea sobre la conectividad de red y el tráfico.</br>
<strong>Uso de los Créditos de CPU:</strong>Hay dos métricas visibles, una muestra el uso de créditos de CPU y la otra el balance de créditos de CPU, que es crucial para entender cómo la instancia está manejando su capacidad computacional y si podría estar sujetando a throttling.</br>
## :sparkler: <u>EC2 y Cloudwash</u>
<div align="center">
    <img src="/images/apache.png?raw=true" alt="Propuesta Inical" width="800px" />
</div>