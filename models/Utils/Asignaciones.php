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

class Asignaciones extends Globals
{
    /**
     * Función para mostrar los datos por id
     */
    public function get_asignaciones_id($id_asig)
    {
        $sql = "SELECT * FROM " . CONTROLADOR_TABLA . "_asignaciones WHERE id_asig = ?";

        $sql = $this->conectar->prepare($sql);
        $sql->bindValue(1, $id_asig);
        $sql->execute();
        return $resultado = $sql->fetchAll();
    }

    /**
     * Insertar un nuevo registro
     */
    public function insert_asignaciones(
        $id_met,
        $link_evidencia_asig,
        $obser_asig,
        $trimestre_asig,
        $cumpl_asig
    ) {
        try {
            $sql = "INSERT INTO " . CONTROLADOR_TABLA . "_asignaciones (id_met, link_evidencia_asig, obser_asig, trimestre_asig, cumpl_asig, id_usuario, id_estado, fechaCreacion_asig) VALUES (?, ?, ?, ?, ?, ?, 1, NOW())";

            $sql = $this->conectar->prepare($sql);
            $sql->bindValue(1, $id_met);
            $sql->bindValue(2, $link_evidencia_asig);
            $sql->bindValue(3, $obser_asig);
            $sql->bindValue(4, $trimestre_asig);
            $sql->bindValue(5, $cumpl_asig);
            $sql->bindValue(6, 3);
            $sql->execute();

            return [
                "status" => "success",
                "message" => "Se registró correctamente la asignacion."
            ];
        } catch (PDOException $e) {
            return [
                "status" => "error",
                "message" => "No se pudo registrar la asignacion. Inténtalo de nuevo."
            ];
        }
    }

    /**
     * Actualizar el registro
     */
    public function update_asignaciones(
        $id_asig,
        $id_met,
        $link_evidencia_asig,
        $obser_asig,
        $trimestre_asig,
        $cumpl_asig
    ) {
        $sql = "UPDATE " . CONTROLADOR_TABLA . "_asignaciones SET id_met = ?, link_evidencia_asig = ?, obser_asig = ?, trimestre_asig = ?, cumpl_asig = ? WHERE id_asig = ?";

        $sql = $this->conectar->prepare($sql);
        $sql->bindValue(1, $id_met);
        $sql->bindValue(2, $link_evidencia_asig);
        $sql->bindValue(3, $obser_asig);
        $sql->bindValue(4, $trimestre_asig);
        $sql->bindValue(5, $cumpl_asig);
        $sql->bindValue(6, $id_asig);
        if ($sql->execute()) {
            return [
                "status" => "success",
                "message" => "La asignacion se actualizó correctamente."
            ];
        } else {
            return [
                "status" => "error",
                "message" => "No se pudo actualizar la asignacion. Por favor, inténtalo de nuevo."
            ];
        }
    }

    /**
     * Obtener lista de todos los registros
     */
    public function get_asignaciones_activo($offset, $limit, $filtro)
    {
        $id_estado = $this->G_estado_activo;
        return $this->get_resultados($offset, $limit, $filtro, $id_estado);
    }

    public function get_asignaciones_inactivo($offset, $limit, $filtro)
    {
        $id_estado = $this->G_estado_inactivo;
        return $this->get_resultados($offset, $limit, $filtro, $id_estado);
    }

    public function get_resultados($offset, $limit, $filtro, $id_estado)
    {
        $sql = "SELECT * FROM " . CONTROLADOR_TABLA . "_asignaciones AS U
                INNER JOIN " . CONTROLADOR_TABLA . "_metas AS R ON U.id_met = R.id_met      
                WHERE U.id_estado = ?";        

        if ($filtro != '') {
            $sql .= " AND (U.link_evidencia_asig LIKE ? OR U.obser_asig LIKE ? OR R.id_met LIKE ? OR U.cumpl_asig LIKE ?
                      OR U.trimestre_asig LIKE ?)";
        }
        $sql .= " ORDER BY U.id_asig DESC LIMIT ?, ?";

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
    public function get_total_asignaciones_activo($filtro)
    {
        $id_estado = $this->G_estado_activo;
        return $this->get_total_asignaciones($filtro, $id_estado);
    }

    public function get_total_asignaciones_inactivo($filtro)
    {
        $id_estado = $this->G_estado_inactivo;
        return $this->get_total_asignaciones($filtro, $id_estado);
    }

    public function get_total_asignaciones($filtro, $id_estado)
    {
        $sql = "SELECT COUNT(*) as total FROM " . CONTROLADOR_TABLA . "_asignaciones AS U
                INNER JOIN " . CONTROLADOR_TABLA . "_metas AS R ON U.id_met = R.id_met  
                WHERE U.id_estado = ?";

        if ($filtro != '') {
            $sql .= " AND (U.link_evidencia_asig LIKE ? OR U.obser_asig LIKE ? OR R.id_met LIKE ? OR U.cumpl_asig LIKE ?
                      OR U.trimestre_asig LIKE ?)";
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
    public function delete_asignaciones($id_asig)
    {
        try {
            $this->conectar->beginTransaction(); // Iniciar la transacción

            $sql = "DELETE FROM " . CONTROLADOR_TABLA . "_asignaciones 
                    WHERE id_asig = ?";

            $sql = $this->conectar->prepare($sql);
            $sql->bindValue(1, $id_asig);
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
    public function desactivar_asignaciones($id_asig)
    {
        $sql = "UPDATE " . CONTROLADOR_TABLA . "_asignaciones 
                    SET 
                        id_estado = ?, 
                        fechaDesactivacion_asig = NOW() 
                    WHERE 
                        id_asig = ?";

        $sql = $this->conectar->prepare($sql);
        $sql->bindValue(1, $this->G_estado_inactivo);
        $sql->bindValue(2, $id_asig);
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
    public function activar_asignaciones($id_asig)
    {
        $sql = "UPDATE " . CONTROLADOR_TABLA . "_asignaciones 
                SET 
                    id_estado = ?, 
                    fechaDesactivacion_asig = ? 
                WHERE 
                    id_asig = ?";

        $sql = $this->conectar->prepare($sql);
        $sql->bindValue(1, $this->G_estado_activo);
        $sql->bindValue(2, "");
        $sql->bindValue(3, $id_asig);
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
     * Obtener los metas de la base de datos
     */
    public function get_Metas()
    {
        $sql = "SELECT * FROM " . CONTROLADOR_TABLA . "_metas 
                WHERE id_met <> ?";

        $sql = $this->conectar->prepare($sql);
        $sql->bindValue(1, 0);
        $sql->execute();

        return $resultado = $sql->fetchAll();
    }

    /**
     * Obtener los metas activos de la base de datos
     */
    public function get_Metas_activos()
    {
        $sql = "SELECT * FROM " . CONTROLADOR_TABLA . "_metas 
                WHERE id_met <> ? AND id_estado = ?";

        $sql = $this->conectar->prepare($sql);
        $sql->bindValue(1, 0);
        $sql->bindValue(2, $this->G_estado_activo);
        $sql->execute();

        return $resultado = $sql->fetchAll();
    }

    /**
     * Verificar si un indicador ya existe en la base de datos
     */
    public function verificar_Asignaciones($link_evidencia_asig)
    {
        $sql = "SELECT COUNT(*) AS count 
                FROM " . CONTROLADOR_TABLA . "_asignaciones AS U
                WHERE U.link_evidencia_asig = ?";

        $stmt = $this->conectar->prepare($sql);
        $stmt->bindValue(1, $link_evidencia_asig);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['count'] > 0) {
            return [
                "status" => "existe",
                "message" => "La asignacion ya está registrada."
            ];
        } else {
            return [
                "status" => "no existe",
                "message" => "despejado"
            ];
        }
    }
}
