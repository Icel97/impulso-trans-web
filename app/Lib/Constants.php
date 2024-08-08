<?php

namespace App\lib;


// Pagos constants
class Constants
{

    const PAGO_MENSAJES = [
        "MOSTRAR_TODOS" => "Error al mostrar los pagos",
        "NO_HAY_PAGOS" => "No hay pagos para mostrar",
        "PAGO_ENVIADO" => "Pago enviado correctamente",
        "PAGO_YA_ENVIADO" => "Ya has enviado un pago",
        "PAGO_NO_ENCONTRADO" => "Pago no encontrado",
        "PAGO_VALIDADO" => "Pago actualizado",
        "PAGO_RECHAZADO" => "Pago actualizado",
    ];

    const SUSCRIPCIONES_MENSAJES = [
        "SUSCRIPCION_NO_ENCONTRADA" => "Suscripción no encontrada",
        "NO_HAY_SUSCRIPCIONES" => "No hay suscripciones para mostrar",
        "SUSCRIPCION_ACTUALIZADA" => "Suscripción ha sido finalizada",
    ];


    const USUARIOS_MENSAJES = [
        "ERROR_MOSTRAR_USUARIOS" => "Error al mostrar los usuarios",
        "NO_HAY_USUARIOS" => "No hay usuarios para mostrar",
        "USUARIO_CREADO" => "Usuario creado correctamente",
        "ERROR_ACTUALIZAR_ROLES" => "Error al actualizar los roles del usuario",
        "ROLES_ASIGNADOS" => "Roles asignados",

    ];

    const GENERICOS = [
        "ERROR" => "Hubo un error",
        "ACCION_NO_RECONOCIDA" => "Acción no reconocida",
        "ACTUALIZADO" => "Actualizado correctamente",
        "ARCHIVO_NO_ENCONTRADO" => "Archivo no encontrado",
        "ELIMINADO" => "Eliminado correctamente",
    ];
}
