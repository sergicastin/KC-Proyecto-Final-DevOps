# Definimos cual es proveedor a usar, en este caso Amazon Web Server
terraform {
  required_providers {
    aws = {
      source  = "hashicorp/aws"
      version = "~> 5.0"
    }
  }
}

#Definimos la region donde vamos a trabajar, usamos Irlanda por tema de latencia
provider "aws" {
  region = "eu-west-1" # Cambia esto a tu región deseada
  access_key = "XXXXXXXXXXXXX"
  secret_key = "XXXXXXXXXXXXXXXXXXXXXXXXXX"
}
