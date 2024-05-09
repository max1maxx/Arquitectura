<?php
/*
 * ----------------------------------------------------------------------------
 * Propiedad de <Armando Josue Velasquez Delgado> <<https://armandovelasquez.com>>
 * Todos los derechos reservados. Ninguna parte de este software puede ser 
 * reproducida, distribuida o transmitida de ninguna forma o por ningún medio, 
 * electrónico o mecánico, incluyendo fotocopias, grabaciones o cualquier otro 
 * sistema de almacenamiento y recuperación de información, sin el permiso 
 * previo por escrito del autor.
 * ----------------------------------------------------------------------------
 */

// Variables globales
require_once '../../models/Utils/components/global.php';

class Objetivos extends Globals
{
    /**
     * Función para mostrar los datos por id
     */
    public function get_objetivos_id($id_obj)
    {
        $sql = "SELECT * FROM " . CONTROLADOR_TABLA . "_objetivos WHERE id_obj = ?";

        $sql = $this->conectar->prepare($sql);
        $sql->bindValue(1, $id_obj);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    /**
     * Insertar un nuevo registro
     */
    public function insert_objetivos(
        $nombre_obj,
        $descrip_obj
    ) {
        try {
            $sql = "INSERT INTO " . CONTROLADOR_TABLA . "_objetivos (nombre_obj, descrip_obj, id_estado, fechaCreacion_obj) VALUES (?, ?, ?, NOW())";

            $sql = $this->conectar->prepare($sql);
            $sql->bindValue(1, $nombre_obj);
            $sql->bindValue(2, $descrip_obj);
            $sql->bindValue(3, 1);
            $sql->execute();

            return [
                "status" => "success",
                "message" => "Se registró correctamente el objetivo."
            ];
        } catch (PDOException $e) {
            return [
                "status" => "error",
                "message" => "No se pudo regiatrar el objetivo. Inténtalo de nuevo."
            ];
        }
    }

    /**
     * Actualizar el registro
     */
    public function update_objetivos(
        $id_obj,
        $nombre_obj,
        $descrip_obj
    ) {
        $sql = "UPDATE " . CONTROLADOR_TABLA . "_objetivos SET nombre_obj = ?, descrip_obj = ? WHERE id_obj = ?";

        $sql = $this->conectar->prepare($sql);
        $sql->bindValue(1, $nombre_obj);
        $sql->bindValue(2, $descrip_obj);
        $sql->bindValue(3, $id_obj);
        if ($sql->execute()) {
            return [
                "status" => "success",
                "message" => "Se actualizó correctamente el objetivo."
            ];
        } else {
            return [
                "status" => "error",
                "message" => "No se pudo actualizar el objetivo. Inténtalo de nuevo."
            ];
        }
    }

    /**
     * Obtener lista de todos los registros
     */
    public function get_objetivos_activo($offset, $limit, $filtro)
    {
        $id_estado = $this->G_estado_activo;
        return $this->get_resultados($offset, $limit, $filtro, $id_estado);
    }

    public function get_objetivos_inactivo($offset, $limit, $filtro)
    {
        $id_estado = $this->G_estado_inactivo;
        return $this->get_resultados($offset, $limit, $filtro, $id_estado);
    }

    public function get_resultados($offset, $limit, $filtro, $id_estado)
    {
        $sql = "SELECT * FROM " . CONTROLADOR_TABLA . "_objetivos AS U
                WHERE U.id_estado = ?";        

        if ($filtro != '') {
            $sql .= " AND (U.nombre_obj LIKE ? OR U.descrip_obj LIKE ?)";
        }
        $sql .= " ORDER BY U.id_obj DESC LIMIT ?, ?";

        $sql = $this->conectar->prepare($sql);

        $params = array($id_estado);

        if ($filtro != '') {
            $filtro = '%' . $filtro . '%';
            $params[] = $filtro;
            $params[] = $filtro;
            $params[] = $offset;
            $params[] = $limit;
        } else {
            $params[] = $offset;
            $params[] = $limit;
        }

        foreach ($params as $key => $value) {
            $sql->bindValue($key + 1, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }

        $sql->execute();

        return $resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
    }



    /**
     * Conteo y filtrado
     */
    public function get_total_objetivos_activo($filtro)
    {
        $id_estado = $this->G_estado_activo;
        return $this->get_total_objetivos($filtro, $id_estado);
    }

    public function get_total_objetivos_inactivo($filtro)
    {
        $id_estado = $this->G_estado_inactivo;
        return $this->get_total_objetivos($filtro, $id_estado);
    }

    public function get_total_objetivos($filtro, $id_estado)
    {
        $sql = "SELECT COUNT(*) as total FROM " . CONTROLADOR_TABLA . "_objetivos AS U
                WHERE U.id_estado = ?";

        if ($filtro != '') {
            $sql .= " AND (U.nombre_obj LIKE ? OR U.descrip_obj LIKE ?)";
        }

        $sql = $this->conectar->prepare($sql);

        $params = array($id_estado);

        if ($filtro != '') {
            $filtro = '%' . $filtro . '%';
            $params[] = $filtro;
            $params[] = $filtro;
        }

        foreach ($params as $key => $value) {
            $sql->bindValue($key + 1, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }

        $sql->execute();
        $resultado = $sql->fetch(PDO::FETCH_ASSOC);

        return $resultado['total'];
    }



    /**
     * Elimina por ID
     */
    public function delete_objetivos($id_obj)
    {
        try {
            $this->conectar->beginTransaction(); // Iniciar la transacción

            $sql = "DELETE FROM " . CONTROLADOR_TABLA . "_objetivos 
                    WHERE id_obj = ?";

            $sql = $this->conectar->prepare($sql);
            $sql->bindValue(1, $id_obj);
            $sql->execute();

            // Confirmar la transacción
            $this->conectar->commit();

            return [
                "status" => "success",
                "message" => "Se eliminó el objetivo correctamente."
            ];
        } catch (PDOException $e) {
            return [
                "status" => "error",
                "message" => "No se pudo eliminar el objetivo. Inténtalo de nuevo."
            ];
        }
    }


    /**
     * Desactivar por ID
     */
    public function desactivar_objetivos($id_obj)
    {
        $sql = "UPDATE " . CONTROLADOR_TABLA . "_objetivos 
                    SET 
                        id_estado = ?, 
                        fechaDesactivacion_obj = NOW() 
                    WHERE 
                        id_obj = ?";

        $sql = $this->conectar->prepare($sql);
        $sql->bindValue(1, $this->G_estado_inactivo);
        $sql->bindValue(2, $id_obj);
        if ($sql->execute()) {
            return [
                "status" => "success",
                "message" => "Se desactivó el objetivo correctamente."
            ];
        } else {
            return [
                "status" => "error",
                "message" => "No se pudo desactivar el objetivo. Inténtalo de nuevo."
            ];
        }
    }



    /**
     * Activar por ID
     */
    public function activar_objetivos($id_obj)
    {
        $sql = "UPDATE " . CONTROLADOR_TABLA . "_objetivos 
                SET 
                    id_estado = ?, 
                    fechaDesactivacion_obj = ? 
                WHERE 
                    id_obj = ?";

        $sql = $this->conectar->prepare($sql);
        $sql->bindValue(1, $this->G_estado_activo);
        $sql->bindValue(2, "");
        $sql->bindValue(3, $id_obj);
        if ($sql->execute()) {
            return [
                "status" => "success",
                "message" => "Se activó el objetivo correctamente."
            ];
        } else {
            return [
                "status" => "error",
                "message" => "No se pudo activar el objetivo. Inténtalo de nuevo."
            ];
        }
    }


    /**
     * Obtener los objetivos de la base de datos
     */
    public function get_Objetivos()
    {
        $sql = "SELECT * FROM " . CONTROLADOR_TABLA . "_objetivos 
                WHERE id_obj <> ?";

        $sql = $this->conectar->prepare($sql);
        $sql->bindValue(1, 0);
        $sql->execute();

        return $resultado = $sql->fetchAll();
    }

    /**
     * Obtener los objetivos activos de la base de datos
     */
    public function get_Objetivos_activos()
    {
        $sql = "SELECT * FROM " . CONTROLADOR_TABLA . "_objetivos 
                WHERE id_obj <> ? AND id_estado = ?";

        $sql = $this->conectar->prepare($sql);
        $sql->bindValue(1, 0);
        $sql->bindValue(2, $this->G_estado_activo);
        $sql->execute();

        return $resultado = $sql->fetchAll();
    }

    /**
     * Verificar si un objetivo ya existe en la base de datos
     */
    public function verificar_Objetivo($nombre_obj)
    {
        $sql = "SELECT COUNT(*) AS count 
                FROM " . CONTROLADOR_TABLA . "_objetivos AS U
                WHERE U.nombre_obj = ?";

        $stmt = $this->conectar->prepare($sql);
        $stmt->bindValue(1, $nombre_obj);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['count'] > 0) {
            return [
                "status" => "existe",
                "message" => "El objetivo ya está registrado."
            ];
        } else {
            return [
                "status" => "no existe",
                "message" => "despejado"
            ];
        }
    }
}
