<?php
namespace Bitrix\Tasks\Kanban;

use \Bitrix\Tasks\Internals\TaskTable as Task;
use \Bitrix\Main\Entity;

/**
 * Class TaskStageTable
 *
 * DO NOT WRITE ANYTHING BELOW THIS
 *
 * <<< ORMENTITYANNOTATION
 * @method static EO_TaskStage_Query query()
 * @method static EO_TaskStage_Result getByPrimary($primary, array $parameters = [])
 * @method static EO_TaskStage_Result getById($id)
 * @method static EO_TaskStage_Result getList(array $parameters = [])
 * @method static EO_TaskStage_Entity getEntity()
 * @method static \Bitrix\Tasks\Kanban\EO_TaskStage createObject($setDefaultValues = true)
 * @method static \Bitrix\Tasks\Kanban\EO_TaskStage_Collection createCollection()
 * @method static \Bitrix\Tasks\Kanban\EO_TaskStage wakeUpObject($row)
 * @method static \Bitrix\Tasks\Kanban\EO_TaskStage_Collection wakeUpCollection($rows)
 */
class TaskStageTable extends Entity\DataManager
{
	/**
	 * Returns DB table name for entity.
	 * @return string
	 */
	public static function getTableName()
	{
		return 'b_tasks_task_stage';
	}

	/**
	 * Returns entity map definition.
	 * @return array
	 */
	public static function getMap()
	{
		return array(
			'ID' => new Entity\IntegerField('ID', array(
				'primary' => true,
				'autocomplete' => true
			)),
			'TASK_ID' => new Entity\IntegerField('TASK_ID', array(
				'required' => true
			)),
			'STAGE_ID' => new Entity\IntegerField('STAGE_ID', array(
				'required' => true
			)),
			'STAGE' => new Entity\ReferenceField(
				'STAGE',
				'Bitrix\Tasks\Kanban\StagesTable',
				array('=this.STAGE_ID' => 'ref.ID')
			)
		);
	}

	/**
	 * Set all tasks by filter in the stage.
	 * @param int $id Stage id.
	 * @param array $filter Filter.
	 * @return void
	 */
	public static function setStageByFilter($id, array $filter)
	{
		$id = intval($id);
		$sqlSearch = \CTasks::GetFilter($filter);

		$connection = \Bitrix\Main\Application::getConnection();
		$sql = $connection->getSqlHelper()->getInsertIgnore(
			self::getTableName(),
			' (TASK_ID, STAGE_ID)',
			' SELECT T.ID, ' . $id . ' FROM ' . Task::getTableName() . ' T '
			. 'WHERE ' . implode(' AND ', $sqlSearch)
		);

		$connection->query($sql);
	}

	/**
	 * Clear for one stage.
	 * @param int $id Stage id.
	 * @return void
	 */
	public static function clearStage($id)
	{
		$res = self::getList(array(
			'filter' => array(
				'STAGE_ID' => $id
			)
		));
		while ($row = $res->fetch())
		{
			self::delete($row['ID']);
		}
	}

	/**
	 * Clear for one task.
	 * @param int $id Task id.
	 * @return void
	 */
	public static function clearTask($id)
	{
		$res = self::getList(array(
			'filter' => array(
				'TASK_ID' => $id
			)
		));
		while ($row = $res->fetch())
		{
			self::delete($row['ID']);
		}
	}
}