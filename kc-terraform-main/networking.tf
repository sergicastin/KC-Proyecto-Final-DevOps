#Configured the Virtual private Network (VPC)
resource "aws_vpc" "mi_vpc" {
  cidr_block = "10.0.0.0/16"
  tags = {
    Name = "Net_project1"  # Cambia esto por el nombre que desees darle a la VPC
  }
}

#Configured the Subnet 
resource "aws_subnet" "mi_subnet" {
  vpc_id                  = aws_vpc.mi_vpc.id
  cidr_block              = "10.0.0.0/24"
  availability_zone       = "eu-west-1a" # Cambia esto a tu zona deseada
  map_public_ip_on_launch = true
   tags = {
    Name = "Subnet_project1"  # Cambia esto por el nombre que desees darle a la VPC
  }
}

#Configured the Security Group
resource "aws_security_group" "mi_sg" {
  vpc_id = aws_vpc.mi_vpc.id

  egress {
    from_port   = 0
    to_port     = 0
    protocol    = "-1"
    cidr_blocks = ["0.0.0.0/0"]
  }

  ingress {
    from_port   = 22
    to_port     = 22
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }

  ingress {
    from_port   = 80
    to_port     = 80
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }

  ingress {
    from_port   = 443
    to_port     = 443
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }
}

#Configured the Gateway
resource "aws_internet_gateway" "gateway" {
  vpc_id = aws_vpc.mi_vpc.id


  tags = {
    Name = "Gateway VPC Irlanda"
  }
}

#Configured the router table
resource "aws_route_table" "public_crt" {
  vpc_id = aws_vpc.mi_vpc.id


  route {
    cidr_block = "0.0.0.0/0"
    gateway_id = aws_internet_gateway.gateway.id
  }


  tags = {
    Name = "Tabla de enrutamiento publica personalizada"
  }
}

resource "aws_route_table_association" "crt_public_subnet" {
  subnet_id      = aws_subnet.mi_subnet.id
  route_table_id = aws_route_table.public_crt.id
}