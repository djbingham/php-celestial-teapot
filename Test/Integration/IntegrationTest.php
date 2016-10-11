<?php
namespace Test\Integration\Connection;

use Test\Abstractory\IntegrationTest;

class PdoConnectionTest extends IntegrationTest
{
	/**
	 * @var string
	 */
	private $fixtureFile;

	protected function getDataSet()
	{
		if (!$this->fixtureFile) {
			$this->fixtureFile = implode([dirname(__DIR__), 'Sample', 'Database', 'fixture.yml'], DIRECTORY_SEPARATOR);
		}
		return $this->createYamlDataSet($this->fixtureFile);
	}

	public function testInsertAndRetrieveData()
	{
		$db = $this->dbWrapper;

		$guestbookTable = $db->value()->table('guestbook');

		$selectContentQuery = $db->query()
			->select()
			->field($guestbookTable->field('id'))
			->field($guestbookTable->field('content'))
			->from($guestbookTable);

		$expectedQueries = [
			"SELECT `guestbook`.`id`, `guestbook`.`content`\nFROM `guestbook`"
		];

		$db->execute($selectContentQuery);
		$dataBeforeInsert = $db->getData();

		$db->begin();
		$expectedQueries[] = 'BEGIN';
		$db->execute(
			$db->query()
				->insert()
				->into($guestbookTable)
				->data(
					$db->value()->tableData()
						->beginRow()
						->set($guestbookTable->field('id'), $db->value()->number(3))
						->set($guestbookTable->field('content'), $db->value()->string('Nice place!'))
						->endRow()
				)
		);
		$expectedQueries[] = <<<EOT
INSERT INTO `guestbook`
(`id`,`content`)
VALUES
(3, "Nice place!")
EOT;

		$db->execute($selectContentQuery);
		$dataAfterInsert = $db->getData();

		$expectedData = $dataBeforeInsert;
		$expectedData[] = ['id' => 3, 'content' => 'Nice place!'];

		$this->assertEquals($expectedData, $dataAfterInsert);
	}

	public function testUpdateAndRetrieveData()
	{
		$db = $this->dbWrapper;

		$guestbookTable = $db->value()->table('guestbook');

		$selectContentQuery = $db->query()
			->select()
			->field($guestbookTable->field('id'))
			->field($guestbookTable->field('content'))
			->from($guestbookTable);

		$expectedQueries = [
			"SELECT `guestbook`.`id`, `guestbook`.`content`\nFROM `guestbook`"
		];

		$db->execute($selectContentQuery);
		$dataBeforeInsert = $db->getData();

		$db->begin();
		$expectedQueries[] = 'BEGIN';
		$db->execute(
			$db->query()
				->update()
				->table($guestbookTable)
				->data(
					$db->value()->tableData()
						->beginRow()
						->set($db->value()->field('content'), $db->value()->string('Nice place!'))
						->endRow()
				)
				->where(
					$db->query()->constraint()
						->setSubject($guestbookTable->field('id'))
						->equals($db->value()->number(2))
				)
		);
		$expectedQueries[] = <<<EOT
UPDATE `guestbook`
SET `guestbook`.`content` = "Nice place!"
WHERE `guestbook`.`id` = 2
EOT;

		$db->execute($selectContentQuery);
		$dataAfterInsert = $db->getData();

		$expectedData = $dataBeforeInsert;
		$expectedData[1] = ['id' => 2, 'content' => 'Nice place!'];

		$this->assertEquals($expectedData, $dataAfterInsert);
	}

	public function testDeleteData()
	{
		$db = $this->dbWrapper;

		$guestbookTable = $db->value()->table('guestbook');

		$selectContentQuery = $db->query()
			->select()
			->field($guestbookTable->field('id'))
			->field($guestbookTable->field('content'))
			->from($guestbookTable);

		$expectedQueries = [
			"SELECT `guestbook`.`id`, `guestbook`.`content`\nFROM `guestbook`"
		];

		$db->execute($selectContentQuery);
		$dataBeforeInsert = $db->getData();

		$db->begin();
		$expectedQueries[] = 'BEGIN';
		$db->execute(
			$db->query()
				->delete()
				->from($guestbookTable)
				->where(
					$db->query()->constraint()
						->setSubject($guestbookTable->field('id'))
						->equals($db->value()->number(2))
				)
		);
		$expectedQueries[] = <<<EOT
DELETE FROM `guestbook`
WHERE `guestbook`.`id` = 2
EOT;

		$db->execute($selectContentQuery);
		$dataAfterInsert = $db->getData();

		$expectedData = $dataBeforeInsert;
		unset($expectedData[1]);

		$this->assertEquals($expectedData, $dataAfterInsert);
	}

	public function testErrorHandling()
	{
		$db = $this->dbWrapper;

		$guestbookTable = $db->value()->table('guestbook');

		$query = $db->query()
			->select()
			->field($guestbookTable->field('NOTHING'))
			->from($guestbookTable);

		$this->setExpectedException('Exception', 'An error occurred executing a MySQL query');

		try {
			$db->execute($query);
		} catch (\Exception $exception) {
			$error = $db->getLastError();

			$expectedError = [
				'HY000',
				1,
				'no such column: guestbook.NOTHING'
			];

			$this->assertEquals($expectedError, $error);
			$this->assertEquals([], $db->getData());

			throw $exception;
		}
	}

	public function testQueryLogging()
	{
		$db = $this->dbWrapper;

		$guestbookTable = $db->value()->table('guestbook');

		$db->execute(
			$db->query()
				->select()
				->field($guestbookTable->field('id'))
				->from($guestbookTable)
		);
		$db->execute(
			$db->query()
				->delete()
				->from($guestbookTable)
		);
		$db->execute(
			$db->query()
				->select()
				->field($guestbookTable->field('id'))
				->from($guestbookTable)
		);

		$expectedQueries = [
			"SELECT `guestbook`.`id`\nFROM `guestbook`",
			'DELETE FROM `guestbook`',
			"SELECT `guestbook`.`id`\nFROM `guestbook`"
		];

		$this->assertEquals($expectedQueries, $db->queryLog());
	}

	public function testTransactionCanBeRolledBack()
	{
		$db = $this->dbWrapper;
		$guestbookTable = $db->value()->table('guestbook');

		$selectContentQuery = $db->query()
			->select()
			->field($guestbookTable->field('content'))
			->from($guestbookTable);

		$expectedQueries = [
			"SELECT `guestbook`.`content`\nFROM `guestbook`"
		];

		$db->execute($selectContentQuery);
		$dataBeforeInsert = $db->getData();

		$db->begin();
		$expectedQueries[] = 'BEGIN';
		$db->execute(
			$db->query()
				->insert()
				->into($guestbookTable)
				->data(
					$db->value()->tableData()
						->beginRow()
						->set($guestbookTable->field('content'), $db->value()->string('Nice place!'))
						->endRow()
				)
		);
		$expectedQueries[] = <<<EOT
INSERT INTO `guestbook`
(`content`)
VALUES
("Nice place!")
EOT;

		$this->assertEquals($expectedQueries, $db->queryLog());

		$db->execute($selectContentQuery);
		$expectedQueries[] = "SELECT `guestbook`.`content`\nFROM `guestbook`";
		$dataAfterInsert = $db->getData();

		$this->assertNotEquals($dataBeforeInsert, $dataAfterInsert);

		$db->rollback();
		$expectedQueries[] = 'ROLLBACK';

		$db->execute($selectContentQuery);
		$expectedQueries[] = "SELECT `guestbook`.`content`\nFROM `guestbook`";
		$dataAfterRollback = $db->getData();

		$this->assertEquals($dataBeforeInsert, $dataAfterRollback);
		$this->assertEquals($expectedQueries, $db->queryLog());
	}

	public function testTransactionCanBeCommitted()
	{
		$db = $this->dbWrapper;
		$guestbookTable = $db->value()->table('guestbook');

		$selectContentQuery = $db->query()
			->select()
			->field($guestbookTable->field('content'))
			->from($guestbookTable);

		$expectedQueries = [
			"SELECT `guestbook`.`content`\nFROM `guestbook`"
		];

		$db->execute($selectContentQuery);
		$dataBeforeInsert = $db->getData();

		$db->begin();
		$expectedQueries[] = 'BEGIN';
		$db->execute(
			$db->query()
				->insert()
				->into($guestbookTable)
				->data(
					$db->value()->tableData()
						->beginRow()
						->set($guestbookTable->field('content'), $db->value()->string('Nice place!'))
						->endRow()
				)
		);
		$expectedQueries[] = <<<EOT
INSERT INTO `guestbook`
(`content`)
VALUES
("Nice place!")
EOT;

		$this->assertEquals($expectedQueries, $db->queryLog());

		$db->execute($selectContentQuery);
		$expectedQueries[] = "SELECT `guestbook`.`content`\nFROM `guestbook`";
		$dataAfterInsert = $db->getData();

		$this->assertNotEquals($dataBeforeInsert, $dataAfterInsert);

		$db->commit();
		$expectedQueries[] = 'COMMIT';

		$db->execute($selectContentQuery);
		$expectedQueries[] = "SELECT `guestbook`.`content`\nFROM `guestbook`";
		$dataAfterRollback = $db->getData();

		$this->assertEquals($dataAfterInsert, $dataAfterRollback);
		$this->assertEquals($expectedQueries, $db->queryLog());
	}
}