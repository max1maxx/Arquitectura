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

class Indicadores extends Globals
{
    /**
     * Función para mostrar los datos por id
     */
    public function get_indicadores_id($id_ind)
    {
        $sql = "SELECT * FROM " . CONTROLADOR_TABLA . "_indicadores WHERE id_ind = ?";

        $sql = $this->conectar->prepare($sql);
        $sql->bindValue(1, $id_ind);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    /**
     * Insertar un nuevo registro
     */
    public function insert_indicadores(
        $nombre_ind,
        $formula_ind,
        $anio_ind,
        $descrip_ind,
        $id_obj
    ) {
        try {
            $sql = "INSERT INTO " . CONTROLADOR_TABLA . "_indicadores (nombre_ind, formula_ind, anio_ind, descrip_ind, id_obj, id_estado, fechaCreacion_ind) VALUES (?, ?, ?, ?, ?, ?, NOW());";

            $sql = $this->conectar->prepare($sql);
            $sql->bindValue(1, $nombre_ind);
            $sql->bindValue(2, $formula_ind);
            $sql->bindValue(3, $anio_ind);
            $sql->bindValue(4, $descrip_ind);
            $sql->bindValue(5, $id_obj);
            $sql->bindValue(6, 1);
            $sql->execute();

            return [
                "status" => "success",
                "message" => "Se registró correctamente el indicador."
            ];
        } catch (PDOException $e) {
            return [
                "status" => "error",
                "message" => "No se pudo regiatrar el indicador. Inténtalo de nuevo."
            ];
        }
    }

    /**
     * Actualizar el registro
     */
    public function update_indicadores(
        $id_ind,
        $nombre_ind,
        $formula_ind,
        $anio_ind,
        $descrip_ind,
        $id_obj
    ) {
        $sql = "UPDATE " . CONTROLADOR_TABLA . "_indicadores SET nombre_ind = ?, formula_ind = ?, anio_ind = ?, descrip_ind = ?, id_obj = ? WHERE id_ind = ?";

        $sql = $this->conectar->prepare($sql);
        $sql->bindValue(1, $nombre_ind);
        $sql->bindValue(2, $formula_ind);
        $sql->bindValue(3, $anio_ind);
        $sql->bindValue(4, $descrip_ind);
        $sql->bindValue(5, $id_obj);
        $sql->bindValue(6, $id_ind);
        if ($sql->execute()) {
            return [
                "status" => "success",
                "message" => "Se actualizó correctamente el indicador."
            ];
        } else {
            return [
                "status" => "error",
                "message" => "No se pudo actualizar el indicador. Inténtalo de nuevo."
            ];
        }
    }

    /**
     * Obtener lista de todos los registros
     */
    public function get_indicadores_activo($offset, $limit, $filtro)
    {
        $id_estado = $this->G_estado_activo;
        return $this->get_resultados($offset, $limit, $filtro, $id_estado);
    }

    public function get_indicadores_inactivo($offset, $limit, $filtro)
    {
        $id_estado = $this->G_estado_inactivo;
        return $this->get_resultados($offset, $limit, $filtro, $id_estado);
    }

    public function get_resultados($offset, $limit, $filtro, $id_estado)
    {
        $sql = "SELECT * FROM " . CONTROLADOR_TABLA . "_indicadores AS U
                INNER JOIN " . CONTROLADOR_TABLA . "_objetivos AS R ON U.id_obj = R.id_obj      
                WHERE U.id_estado = ?";        

        if ($filtro != '') {
            $sql .= " AND (U.nombre_ind LIKE ? OR U.formula_ind LIKE ? OR R.nombre_obj LIKE ? OR U.descrip_ind LIKE ?
                      OR U.anio_ind LIKE ?)";
        }
        $sql .= " ORDER BY U.id_obj DESC LIMIT ?, ?";

        $sql = $this->conectar->prepare($sql);

        $params = array($id_estado);

        if ($filtro != '') {
            $filtro = '%' . $filtro . '%';
            $params[] = $filtro;
            $params[] = $filtro;
            $params[] = $filtro;
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
    public function get_total_indicadores_activo($filtro)
    {
        $id_estado = $this->G_estado_activo;
        return $this->get_total_indicadores($filtro, $id_estado);
    }

    public function get_total_indicadores_inactivo($filtro)
    {
        $id_estado = $this->G_estado_inactivo;
        return $this->get_total_indicadores($filtro, $id_estado);
    }

    public function get_total_indicadores($filtro, $id_estado)
    {
        $sql = "SELECT COUNT(*) as total FROM " . CONTROLADOR_TABLA . "_indicadores AS U
                INNER JOIN " . CONTROLADOR_TABLA . "_objetivos AS R ON U.id_obj = R.id_obj  
                WHERE U.id_estado = ?";

        if ($filtro != '') {
            $sql .= " AND (U.nombre_ind LIKE ? OR U.formula_ind LIKE ? OR R.nombre_obj LIKE ? OR U.descrip_ind LIKE ?
                      OR U.anio_ind LIKE ?)";
        }

        $sql = $this->conectar->prepare($sql);

        $params = array($id_estado);

        if ($filtro != '') {
            $filtro = '%' . $filtro . '%';
            $params[] = $filtro;
            $params[] = $filtro;
            $params[] = $filtro;
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
    public function delete_indicadores($id_ind)
    {
        try {
            $this->conectar->beginTransaction(); // Iniciar la transacción

            $sql = "DELETE FROM " . CONTROLADOR_TABLA . "_indicadores 
                    WHERE id_ind = ?";

            $sql = $this->conectar->prepare($sql);
            $sql->bindValue(1, $id_ind);
            $sql->execute();

            // Confirmar la transacción
            $this->conectar->commit();

            return [
                "status" => "success",
                "message" => "Se eliminó el indicador correctamente."
            ];
        } catch (PDOException $e) {
            return [
                "status" => "error",
                "message" => "No se pudo eliminar el indicador. Inténtalo de nuevo."
            ];
        }
    }


    /**
     * Desactivar por ID
     */
    public function desactivar_indicadores($id_ind)
    {
        $sql = "UPDATE " . CONTROLADOR_TABLA . "_indicadores 
                    SET 
                        id_estado = ?, 
                        fechaDesactivacion_ind = NOW() 
                    WHERE 
                        id_ind = ?";

        $sql = $this->conectar->prepare($sql);
        $sql->bindValue(1, $this->G_estado_inactivo);
        $sql->bindValue(2, $id_ind);
        if ($sql->execute()) {
            return [
                "status" => "success",
                "message" => "Se desactivó el indicador correctamente."
            ];
        } else {
            return [
                "status" => "error",
                "message" => "No se pudo desactivar el indicador. Inténtalo de nuevo."
            ];
        }
    }



    /**
     * Activar por ID
     */
    public function activar_indicadores($id_ind)
    {
        $sql = "UPDATE " . CONTROLADOR_TABLA . "_indicadores 
                SET 
                    id_estado = ?, 
                    fechaDesactivacion_ind = ? 
                WHERE 
                    id_ind = ?";

        $sql = $this->conectar->prepare($sql);
        $sql->bindValue(1, $this->G_estado_activo);
        $sql->bindValue(2, "");
        $sql->bindValue(3, $id_ind);
        if ($sql->execute()) {
            return [
                "status" => "success",
                "message" => "Se activó el indicador correctamente."
            ];
        } else {
            return [
                "status" => "error",
                "message" => "No se pudo activar el indicador. Inténtalo de nuevo."
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
     * Verificar si un indicador ya existe en la base de datos
     */
    public function verificar_Indicador($nombre_ind)
    {
        $sql = "SELECT COUNT(*) AS count 
                FROM " . CONTROLADOR_TABLA . "_indicadores AS U
                WHERE U.nombre_ind = ?";

        $stmt = $this->conectar->prepare($sql);
        $stmt->bindValue(1, $nombre_ind);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['count'] > 0) {
            return [
                "status" => "existe",
                "message" => "El indicador ya está registrado."
            ];
        } else {
            return [
                "status" => "no existe",
                "message" => "despejado"
            ];
        }
    }
}
