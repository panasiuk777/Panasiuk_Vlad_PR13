function GameCard(props) {
  return (
    <div>
      <h2>{props.title}</h2>
      <p>Жанр: {props.genre}</p>
      <p>Платформа: {props.platform}</p>
    </div>
  );
}

export default GameCard;