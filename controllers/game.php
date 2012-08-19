<?php
class Game
{
	// Состояния игры
	const STATE_START = 0;

	// Времена протухания в секундах
	const TIME_FOR_DELETE = 120;

	private static $_instance = null;

	public function __construct()
	{
	}


	public static function instance()
	{
		if( self::$_instance === null )
			self::$_instance = new Game();
		return self::$_instance;
	}


	/**
	 * Получение списка комнат
	 * Возвращаются все комнаты, которые не находятся в состоянии игры
	 */
	public function getRooms( $userId )
	{
		$res = RoomQuery::create()
			->select('*')
			->withColumn('User2Room.user_id', 'UserId')
			->joinWith('User2Room', Criteria::INNER_JOIN)
			->where('Room.State = ?', Room::STATE_WAIT)
			->find();

		$rooms = array();
		foreach( $res as $val )
		{
			$roomId = $val['Room.Id'];
			if( !isset($rooms[$roomId]) )
			{
				$val['users'][] = $val['UserId'];
				$rooms[$roomId] = $val;
			}
			else
			{
				$rooms[$roomId]['users'][] = $val['UserId'];
			}
		}
		return $rooms;
	}


	/**
	 * Найти комнату в которой находится пользователь
	 */
	public function findRoomByUserId( $userId )
	{
		$res = User2RoomQuery::create()
			->findOneByUserId( $userId );
		return ($res === null)
			? null
			: $res->getRoomId();
	}


	/**
	 * Создать комнату
	 * Если пользователь уже создал комнату, то вываливаемся с ошибкой
	 */
	public function createRoom( $userId )
	{
		// Проверяем, находится ли игрок уже в какой-нибудь комнате
		$res = User2RoomQuery::create()
			->findOneByUserId( $userId );
		if( $res !== null )
			throw new GameException( 'User already in room' );

		// Комната
		$room = new Room();
		$room->setState( Room::STATE_WAIT );
		$room->setTimeStamp( time() );

		$user2room = new User2Room();
		$user2room->setUserId( $userId );
		$user2room->setRoom( $room );
		$user2room->save();
	}


	/**
	 * Войти в комнату
	 * Если игрок уже находился в комнате, то выходим их нее и заходим в новую
	 */
	public function enterRoom( $userId, $roomId )
	{
		// Если комната заполнена, то не входим в нее
		$count = User2RoomQuery::create()
			->where( 'User2Room.RoomId = ?', $roomId )
			->count();
		if( $count >= Room::MAX_USERS )
			throw new GameException( 'Room is full' );

		// Если игрок уже в какой-то комнате, сперва покидаем ее
		$room = RoomQuery::create()
			->joinWith('User2Room', Criteria::INNER_JOIN)
			->where('User2Room.UserId = ?', $userId)
			->findOne();
		if( $room !== null )
		{
			// Проверяем состояние комнаты - только из STATE_WAIT можно выйти
			if( $room->getState() == Room::STATE_WAIT )
				$this->leaveRoom( $userId, $room->getId() );
			else
				throw new GameException( "You don't leave room=".$roomId );
		}

		// Если комната, в которую хотим войти, не найдена, то это ошибка
		// Это значит мы пытаемся войти или в ту же самую комнату или в несуществующую
		$room = RoomQuery::create()
			->where('Room.Id = ?', $roomId)
			->_and()
			->where('Room.State = ?', Room::STATE_WAIT)
			->findOne();
		if( $room === null )
			throw new GameException( 'Room '.$roomId.' not found' );

		// Присоединяемся к новой комнате
		$user2room = new User2Room();
		$user2room->setUserId( $userId );
		$user2room->setRoomId( $roomId );
		$user2room->save();
	}


	/**
	 * Покинуть комнату
	 */
	public function leaveRoom( $userId, $roomId )
	{
		// Если игрок нигде не находится, то покидать нечего
		$user2Query = User2RoomQuery::create()
			->findOneByUserId( $userId );
		if( $user2Query === null )
			throw new GameException( 'Player is nowhere' );

		// Пытаемся покинуть не свою комнату
		if( $user2Query->getRoomId() != $roomId )
			throw new GameException( 'Rooms not equal' );

		// Выйти можем из комнаты с любым статусом
		$room = RoomQuery::create()
			->findOneById( $roomId );

		$count = User2RoomQuery::create()
			->where( 'User2Room.RoomId = ?', $room->getId() )
			->count();
		if( $count <= 1 )
		{
			// В комнате никого не осталось, удаляем ее
			$room->delete();
		}

		// Удаляем привязку к комнате
		$user2Query->delete();
	}


	/**
	 * Сохранить игровое поле
	 * $fieldData - string
	 */
	public function saveField( $userId, $fieldData )
	{
		// Если игрок уже сохранил поле ранее, то удаляем старое и записываем новое
		$field = FieldQuery::create()
			->findOneByUserId( $userId );
		if( $field !== null )
		{
			$field->delete();
		}

		$field = new Field();
		$field->setUserId( $userId );
		$field->setData( $fieldData );
		$field->save();
	}


	/**
	 * Запуск игры
	 */ 
/*	public function startGame()
	{
		$gameState = isset( $_POST['gameState'] )? $_POST['gameState'] : self::STATE_START;
		switch( $gameState )
		{
			case self::STATE_START:
				$content = $this->drawStartScreen();
				break;
		}

		return $content;
	}*/
}
