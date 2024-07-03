resource "aws_key_pair" "ssh_key" {
  key_name   = "mi_clave3_ssh"
  public_key = file("~/.ssh/id_rsa.pub") # Asegúrate de que la ruta al archivo de clave pública sea correcta
}
resource "aws_instance" "apache_server" {
  ami           = "ami-0776c814353b4814d" # Asegúrate de cambiar esto por una AMI adecuada para tu región
  instance_type = "t2.medium"
  subnet_id     = aws_subnet.mi_subnet.id
  vpc_security_group_ids = [aws_security_group.mi_sg.id]
  key_name               = aws_key_pair.ssh_key.key_name

  user_data = <<-EOF
               #!/bin/bash
                sudo apt-get update
                sudo apt-get install -y apache2
                sudo systemctl start apache2
                sudo systemctl enable apache2
                echo "<h1>Bienvenido a Apache en Ubuntu AWS EC2</h1>" > /var/www/html/index.html
                apt install certbot
                apt install python3-certbot-apache
                certbot renew --dry-run
                EOF

  tags = {
    Name = "ApacheServer"
  }
}

# Asignar una dirección IP pública estática a la instancia EC2
resource "aws_eip" "apache_eip" {
  instance = aws_instance.apache_server.id  
  }
