<?php

require("Database.php");
class Api
{
    private $cn;

    public function __construct()
    {
        $this->cn = Database::getInstance();
    }

    public function getUSer($phone)
    {
        $sql = "SELECT * FROM usr WHERE phone = ?";
        $stmt = $this->cn->prepare($sql);
        $stmt->bind_param("s", $phone);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getTransferences($phone)
    {
        $sql = "SELECT * FROM movements WHERE usr_phone = ?";
        $stmt = $this->cn->prepare($sql);
        $stmt->bind_param("s", $phone);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        return $data;
    }

    public function createUser($phone, $name, $password)
    {
        $cash = 0;

        try {
            // Sentencia SQL preparada para evitar la inyección de SQL
            $sql = "INSERT INTO usr (phone, name, cash) VALUES (?, ?, ?)";
            $stmt = $this->cn->prepare($sql);
            $stmt->bind_param("ssi", $phone, $name, $cash);
            $stmt->execute();

            // Sentencia SQL preparada para evitar la inyección de SQL
            $sql = "INSERT INTO account (usr_phone, psswd) VALUES (?, ?)";
            $stmt = $this->cn->prepare($sql);
            $stmt->bind_param("ss", $phone, $password);
            // Ejecutar la sentencia
            $stmt->execute();

            return array('success' => "Usuario registrado con exito!");
        } catch (Exception $e) {
            // Handle the exception (e.g., log the error, show an error message)
            return array('error' => $e->getMessage());
            // You might want to consider rolling back the transaction if necessary
            // $this->cn->rollback();
        }
    }

    public function validateUser($phone, $password)
    {
        $cash = 0;

        try {
            $sql = "SELECT * FROM account WHERE usr_phone = ?";
            $stmt = $this->cn->prepare($sql);
            $stmt->bind_param("s", $phone);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $usr = $resultado->fetch_assoc();

            if ($usr['psswd'] === $password and $usr['usr_phone'] === $phone) {
                return array('mensaje' => 'ok');
            } else {
                return array('mensaje' => 'Datos incorrectos');
            }

        } catch (Exception $e) {
            // Handle the exception (e.g., log the error, show an error message)
            return array('error' => $e->getMessage());
            // You might want to consider rolling back the transaction if necessary
            // $this->cn->rollback();
        }
    }

    public function money($phone)
    {
        try {
            $sql = "SELECT cash FROM usr WHERE phone = ?";
            $stmt = $this->cn->prepare($sql);
            $stmt->bind_param("s", $phone);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $cash = $resultado->fetch_assoc();

            if ($cash) {
                return array('mensaje' => $cash);
            } else {
                return array('mensaje' => "Error de conexion");
            }

        } catch (Exception $e) {
            // Handle the exception (e.g., log the error, show an error message)
            return array('error' => $e->getMessage());
            // You might want to consider rolling back the transaction if necessary
            // $this->cn->rollback();
        }
    }

    public function deposit($phone, $money)
    {
        try {
            $current = $this->money($phone);
            $current = $current['mensaje']['cash'];
            $total = $current + $money;

            $sql = "UPDATE usr SET cash = ? WHERE phone = ?";
            $stmt = $this->cn->prepare($sql);
            $stmt->bind_param("is", $total, $phone);
            $stmt->execute();

            $report = "Ha depositado $money de su cuenta";
            $currentDate = date('Y-m-d');

            $sql = "INSERT INTO movements (usr_phone, date, report) values (?, ?, ?)";
            $stmt = $this->cn->prepare($sql);
            $stmt->bind_param("sss", $phone, $currentDate, $report);
            $stmt->execute();

            return array('mensaje' => "Ha depositado $money a su cuenta");

        } catch (Exception $e) {
            // Handle the exception (e.g., log the error, show an error message)
            return array('error' => $e->getMessage());
            // You might want to consider rolling back the transaction if necessary
            // $this->cn->rollback();
        }
    }

    public function withdraw($phone, $money)
    {
        $current = $this->money($phone);
        $current = $current['mensaje']['cash'];

        if ($money <= $current) {
            $total = $current - $money;

            try {
                $sql = "UPDATE usr SET cash = ? WHERE phone = ?";
                $stmt = $this->cn->prepare($sql);
                $stmt->bind_param("is", $total, $phone);
                $stmt->execute();

                $report = "Ha retirado $money de su cuenta";
                $currentDate = date('Y-m-d');

                $sql = "INSERT INTO movements (usr_phone, date, report) values (?, ?, ?)";
                $stmt = $this->cn->prepare($sql);
                $stmt->bind_param("sss", $phone, $currentDate, $report);
                $stmt->execute();

                return array('mensaje' => $report);

            } catch (Exception $e) {
                // Handle the exception (e.g., log the error, show an error message)
                return array('error' => $e->getMessage());
                // You might want to consider rolling back the transaction if necessary
                // $this->cn->rollback();
            }
        } else {
            return array('mensaje' => "No tiene suficiente dinero en la cuenta");
        }
    }

    public function transfer($sender, $reciever, $money)
    {
        try {

            $wtd = $this->withdraw($sender, $money);
            if ($wtd['mensaje'] === "No tiene suficiente dinero en la cuenta") {
                return array('mensaje' => "Error, fondos insuficientes");
            }

            $current = $this->money($reciever);
            $current = $current['mensaje']['cash'];
            $total = $current + $money;
            $currentDate = date('Y-m-d');
            $report = "Transferido $money a $reciever";

            $sql = "UPDATE usr SET cash = ? WHERE phone = ?";
            $stmt = $this->cn->prepare($sql);
            $stmt->bind_param("is", $total, $reciever);
            $stmt->execute();

            $sql = "INSERT INTO movements (usr_phone, date, report) values (?, ?, ?)";
            $stmt = $this->cn->prepare($sql);
            $stmt->bind_param("sss", $sender, $currentDate, $report);
            $stmt->execute();

            return array('mensaje' => "Ha transferido $money al cel: $reciever");

        } catch (Exception $e) {
            // Handle the exception (e.g., log the error, show an error message)
            return array('error' => $e->getMessage());
            // You might want to consider rolling back the transaction if necessary
            // $this->cn->rollback();
        }
    }
}
?>