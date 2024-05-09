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

class Metas extends Globals
{
    /**
     * Función para mostrar los datos por id
     */
    public function get_metas_id($id_met)
    {
        $sql = "SELECT * FROM " . CONTROLADOR_TABLA . "_metas WHERE id_met = ?";

        $sql = $this->conectar->prepare($sql);
        $sql->bindValue(1, $id_met);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    /**
     * Insertar un nuevo registro
     */
    public function insert_metas(
        $id_ind,
        $estado_met,
        $linea_base_met,
        $comportamiento_met,
        $unidad_medida_met,
        $sentido_medicion_met,
        $denominador_met,
        $primer_trimestre_met,
        $segundo_trimestre_met,
        $tercer_trimestre_met
    ) {
        try {
            $sql = "INSERT INTO " . CONTROLADOR_TABLA . "_metas (id_ind, estado_met, linea_base_met, comportamiento_met, unidad_medida_met, sentido_medicion_met, denominador_met, primer_trimestre_met, segundo_trimestre_met, tercer_trimestre_met, id_estado, fechaCreacion_met) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, NOW())";

            $sql = $this->conectar->prepare($sql);
            $sql->bindValue(1, $id_ind);
            $sql->bindValue(2, $estado_met);
            $sql->bindValue(3, $linea_base_met);
            $sql->bindValue(4, $comportamiento_met);
            $sql->bindValue(5, $unidad_medida_met);
            $sql->bindValue(6, $sentido_medicion_met);
            $sql->bindValue(7, $denominador_met);
            $sql->bindValue(8, $primer_trimestre_met);
            $sql->bindValue(9, $segundo_trimestre_met);
            $sql->bindValue(10, $tercer_trimestre_met);
            $sql->execute();

            return [
                "status" => "success",
                "message" => "Se registró correctamente la meta."
            ];
        } catch (PDOException $e) {
            return [
                "status" => "error",
                "message" => "No se pudo registrar la meta. Inténtalo de nuevo."
            ];
        }
    }

    /**
     * Actualizar el registro
     */
    public function update_metas(
        $id_met,
        $id_ind,
        $estado_met,
        $linea_base_met,
        $comportamiento_met,
        $unidad_medida_met,
        $sentido_medicion_met,
        $denominador_met,
        $primer_trimestre_met,
        $segundo_trimestre_met,
        $tercer_trimestre_met
    ) {
        $sql = "UPDATE " . CONTROLADOR_TABLA . "_metas SET id_ind = ?, estado_met = ?, linea_base_met = ?, comportamiento_met = ?, unidad_medida_met = ?, sentido_medicion_met = ?, denominador_met = ?, primer_trimestre_met = ?, segundo_trimestre_met = ?, tercer_trimestre_met = ? WHERE id_met = ?";

        $sql = $this->conectar->prepare($sql);
        $sql->bindValue(1, $id_ind);
        $sql->bindValue(2, $estado_met);
        $sql->bindValue(3, $linea_base_met);
        $sql->bindValue(4, $comportamiento_met);
        $sql->bindValue(5, $unidad_medida_met);
        $sql->bindValue(6, $sentido_medicion_met);
        $sql->bindValue(7, $denominador_met);
        $sql->bindValue(8, $primer_trimestre_met);
        $sql->bindValue(9, $segundo_trimestre_met);
        $sql->bindValue(10, $tercer_trimestre_met);
        $sql->bindValue(11, $id_met);
        if ($sql->execute()) {
            return [
                "status" => "success",
                "message" => "La meta se actualizó correctamente."
            ];
        } else {
            return [
                "status" => "error",
                "message" => "No se pudo actualizar la meta. Por favor, inténtalo de nuevo."
            ];
        }
    }

    /**
     * Obtener lista de todos los registros
     */
    public function get_metas_activo($offset, $limit, $filtro)
    {
        $id_estado = $this->G_estado_activo;
        return $this->get_resultados($offset, $limit, $filtro, $id_estado);
    }

    public function get_metas_inactivo($offset, $limit, $filtro)
    {
        $id_estado = $this->G_estado_inactivo;
        return $this->get_resultados($offset, $limit, $filtro, $id_estado);
    }

    public function get_resultados($offset, $limit, $filtro, $id_estado)
    {
        $sql = "SELECT * FROM " . CONTROLADOR_TABLA . "_metas AS U
                INNER JOIN " . CONTROLADOR_TABLA . "_indicadores AS R ON U.id_ind = R.id_ind      
                WHERE U.id_estado = ?";        

        if ($filtro != '') {
            $sql .= " AND (U.estado_met LIKE ? OR U.linea_base_met LIKE ? OR R.nombre_ind LIKE ? OR U.unidad_medida_met LIKE ?
                      OR U.comportamiento_met LIKE ?)";
        }
        $sql .= " ORDER BY U.id_met DESC LIMIT ?, ?";

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
    public function get_total_metas_activo($filtro)
    {
        $id_estado = $this->G_estado_activo;
        return $this->get_total_metas($filtro, $id_estado);
    }

    public function get_total_metas_inactivo($filtro)
    {
        $id_estado = $this->G_estado_inactivo;
        return $this->get_total_metas($filtro, $id_estado);
    }

    public function get_total_metas($filtro, $id_estado)
    {
        $sql = "SELECT COUNT(*) as total FROM " . CONTROLADOR_TABLA . "_metas AS U
                INNER JOIN " . CONTROLADOR_TABLA . "_indicadores AS R ON U.id_ind = R.id_ind  
                WHERE U.id_estado = ?";

        if ($filtro != '') {
            $sql .= " AND (U.estado_met LIKE ? OR U.linea_base_met LIKE ? OR R.nombre_ind LIKE ? OR U.unidad_medida_met LIKE ?
                      OR U.comportamiento_met LIKE ?)";
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
    public function delete_metas($id_met)
    {
        try {
            $this->conectar->beginTransaction(); // Iniciar la transacción

            $sql = "DELETE FROM " . CONTROLADOR_TABLA . "_metas 
                    WHERE id_met = ?";

            $sql = $this->conectar->prepare($sql);
            $sql->bindValue(1, $id_met);
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
    public function desactivar_metas($id_met)
    {
        $sql = "UPDATE " . CONTROLADOR_TABLA . "_metas 
                    SET 
                        id_estado = ?, 
                        fechaDesactivacion_met = NOW() 
                    WHERE 
                        id_met = ?";

        $sql = $this->conectar->prepare($sql);
        $sql->bindValue(1, $this->G_estado_inactivo);
        $sql->bindValue(2, $id_met);
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
    public function activar_metas($id_met)
    {
        $sql = "UPDATE " . CONTROLADOR_TABLA . "_metas 
                SET 
                    id_estado = ?, 
                    fechaDesactivacion_met = ? 
                WHERE 
                    id_met = ?";

        $sql = $this->conectar->prepare($sql);
        $sql->bindValue(1, $this->G_estado_activo);
        $sql->bindValue(2, "");
        $sql->bindValue(3, $id_met);
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
     * Obtener los indicadores de la base de datos
     */
    public function get_Indicadores()
    {
        $sql = "SELECT * FROM " . CONTROLADOR_TABLA . "_indicadores 
                WHERE id_ind <> ?";

        $sql = $this->conectar->prepare($sql);
        $sql->bindValue(1, 0);
        $sql->execute();

        return $resultado = $sql->fetchAll();
    }

    /**
     * Obtener los indicadores activos de la base de datos
     */
    public function get_Indicadores_activos()
    {
        $sql = "SELECT * FROM " . CONTROLADOR_TABLA . "_indicadores 
                WHERE id_ind <> ? AND id_estado = ?";

        $sql = $this->conectar->prepare($sql);
        $sql->bindValue(1, 0);
        $sql->bindValue(2, $this->G_estado_activo);
        $sql->execute();

        return $resultado = $sql->fetchAll();
    }

    /**
     * Verificar si un indicador ya existe en la base de datos
     */
    public function verificar_Metas($estado_met)
    {
        $sql = "SELECT COUNT(*) AS count 
                FROM " . CONTROLADOR_TABLA . "_metas AS U
                WHERE U.estado_met = ?";

        $stmt = $this->conectar->prepare($sql);
        $stmt->bindValue(1, $estado_met);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['count'] > 0) {
            return [
                "status" => "existe",
                "message" => "La meta ya está registrada."
            ];
        } else {
            return [
                "status" => "no existe",
                "message" => "despejado"
            ];
        }
    }
}
