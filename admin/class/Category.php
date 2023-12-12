<?php
class Category
{

	private $categoryTable = 'cms_category';
	private $conn;
	private $id;
	private $name;
	public function __construct($db)
	{
		$this->conn = $db;
	}

	public function getCategoryListing()
	{

		$sqlQuery = "
			SELECT id, name
			FROM " . $this->categoryTable . "  
			 ";

		if (!empty($_POST["search"]["value"])) {
			$sqlQuery .= ' name LIKE "%' . $_POST["search"]["value"] . '%" ';
		}

		if (!empty($_POST["order"])) {
			$sqlQuery .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
		} else {
			$sqlQuery .= 'ORDER BY id DESC ';
		}
		if ($_POST["length"] != -1) {
			$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}

		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->execute();
		$result = $stmt->get_result();

		$stmtTotal = $this->conn->prepare("SELECT * FROM " . $this->categoryTable);
		$stmtTotal->execute();
		$allResult = $stmtTotal->get_result();
		$allRecords = $allResult->num_rows;

		$displayRecords = $result->num_rows;
		$categories = array();
		while ($category = $result->fetch_assoc()) {
			$rows = array();
			$rows[] = $category['id'];
			$rows[] = $category['name'];
			$rows[] = '<a href="add_categories.php?id=' . $category["id"] . '" class="btn btn-warning btn-xs update">Edit</a>';
			$rows[] = '<button type="button" name="delete" id="' . $category["id"] . '" class="btn btn-danger btn-xs delete" >Delete</button>';
			$categories[] = $rows;
		}

		$output = array(
			"draw"	=>	intval($_POST["draw"]),
			"iTotalRecords"	=> 	$displayRecords,
			"iTotalDisplayRecords"	=>  $allRecords,
			"data"	=> 	$categories
		);

		echo json_encode($output);
	}

	public function getCategory()
	{
		if ($this->getId()) {
			$sqlQuery = "
			SELECT id, name
			FROM " . $this->categoryTable . " 			
			WHERE id = ? ";
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->bind_param("i", $this->id);
			$stmt->execute();
			$result = $stmt->get_result();
			$category = $result->fetch_assoc();
			return $category;
		}
	}

	public function insert()
	{

		if ($this->getName()) {

			$stmt = $this->conn->prepare("
				INSERT INTO " . $this->categoryTable . "(`name`)
				VALUES(?)");

			$this->setName(htmlspecialchars(strip_tags($this->getName())));
			$stmt->bind_param("s", $this->getName());

			if ($stmt->execute()) {
				return $stmt->insert_id;
			}
		}
	}

	public function update()
	{

		if ($this->id) {
			$stmt = $this->conn->prepare("
				UPDATE " . $this->categoryTable . " 
				SET name= ?
				WHERE id = ?");

			$this->id = htmlspecialchars(strip_tags($this->id));
			$this->name = htmlspecialchars(strip_tags($this->name));

			$stmt->bind_param("si", $this->name, $this->id);

			if ($stmt->execute()) {
				return true;
			}
		}
	}

	public function delete()
	{

		if ($this->id) {

			$stmt = $this->conn->prepare("
				DELETE FROM " . $this->categoryTable . " 				
				WHERE id = ?");

			$this->id = htmlspecialchars(strip_tags($this->id));

			$stmt->bind_param("i", $this->id);

			if ($stmt->execute()) {
				return true;
			}
		}
	}

	public function totalCategory()
	{
		$sqlQuery = "SELECT * FROM " . $this->categoryTable;
		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->execute();
		$result = $stmt->get_result();
		return $result->num_rows;
	}

	/**
	 * Get the value of id
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Set the value of id
	 *
	 * @return  self
	 */
	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}

	/**
	 * Get the value of name
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Set the value of name
	 *
	 * @return  self
	 */
	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}
}
