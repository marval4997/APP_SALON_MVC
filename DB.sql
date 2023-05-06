CREATE DATABASE app_salon;


CREATE TABLE usuarios(
    id INT(11) AUTO_INCREMENT NOT NULL,
    nombre VARCHAR(60) NOT NULL,
    apellido VARCHAR(60) NOT NULL,
    email VARCHAR(60) NOT NULL,
    telefono VARCHAR(60) NOT NULL,
    admin TINYINT(1) ,
    confirmado TINYINT(1) ,
    token VARCHAR(15),
    CONSTRAINT pk_usuario PRIMARY KEY(id)
);



CREATE TABLE servicios(
    id INT(11) AUTO_INCREMENT NOT NULL,
    nombre VARCHAR(60) NOT NULL,
    precio DECIMAL(5,2),
    CONSTRAINT pk_servicio PRIMARY KEY(id)
);


CREATE TABLE citas(
    id INT(11) AUTO_INCREMENT NOT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    usuario_id INT(11) NOT NULL ,
    CONSTRAINT pk_cita PRIMARY KEY(id),
    CONSTRAINT fk_cita_usuario FOREIGN KEY(usuario_id) REFERENCES usuarios(id)
);

CREATE TABLE citas_servicios(
    id INT(11) AUTO_INCREMENT NOT NULL,
    cita_id INT(11) NOT NULL,
    servicio_id INT(11) NOT NULL,
    CONSTRAINT pk_cita_servicio PRIMARY KEY(id),
    CONSTRAINT fk_cita_servicio_cita FOREIGN KEY(cita_id) REFERENCES citas(id),
    CONSTRAINT fk_cita_servicio_servicio FOREIGN KEY(servicio_id) REFERENCES servicios(id)
);

--join--
USE app_salon;
SELECT citas.id, citas.hora, 
CONCAT(usuarios.nombre, ' ', usuarios.apellido) as cliente ,
usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio FROM citas 
LEFT OUTER JOIN usuarios ON citas.usuario_id=usuarios.id
LEFT OUTER JOIN citas_servicios ON citas_servicios.cita_id=citas.id
LEFT OUTER JOIN servicios ON servicios.id=citas_servicios.servicio_id
