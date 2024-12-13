# Dockerfile
FROM ubuntu:latest

# Instalar Apache2
RUN apt-get update && apt-get install -y apache2

# Instalar MariaDB Client
RUN apt-get install -y mariadb-client

# Instalar XFCE e VNC para interface gráfica
RUN apt-get install -y xfce4 xfce4-goodies tightvncserver

# Configurar VNC
RUN mkdir ~/.vnc
RUN echo "password" | vncpasswd -f > ~/.vnc/passwd
RUN chmod 600 ~/.vnc/passwd

# Expor a porta do VNC
EXPOSE 5900

# Iniciar o Apache2 e VNC
CMD service apache2 start && vncserver :1 -geometry 1280x800 -depth 16 && tail -f /dev/null
