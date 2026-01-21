import { useEffect, useState } from "react";
import "../css/loader.css";


// Galvene un kājene – strukturālas komponentes bez funkcijām vai datiem
function Header() {
    return (
        <header className="bg-green-500 mb-8 py-2 sticky top-0">
            <div className="px-2 py-2 font-serif text-green-50 text-xl leading-6 md:container md:mx-auto">
                Spēļu katalogs
            </div>
        </header>
    );
}

function Footer() {
    return (
        <footer className="bg-neutral-300 mt-8">
            <div className="py-8 md:container md:mx-auto px-2">
                Dāvids Egle, 2026
            </div>
        </footer>
    );
}

// Galvenā lietotnes komponente
export default function App() {
    const [selectedGameID, setSelectedGameID] = useState(null);

    // funkcija Game ID saglabāšanai stāvoklī
    function handleGameSelection(gameID) {
        setSelectedGameID(gameID);
    }

    // funkcija spēles izvēles atcelšanai
    function handleGoingBack() {
        setSelectedGameID(null);
    }

    return (
        <>
            <Header />

            <main className="mb-8 px-2 md:container md:mx-auto">
                {
				selectedGameID
				? <GamePage
                        selectedGameID={selectedGameID}
                        handleGameSelection={handleGameSelection}
                        handleGoingBack={handleGoingBack}
                />
                : <Homepage handleGameSelection={handleGameSelection} />
                }
            </main>
            <Footer />
        </>
    );
}


// Sākumlapa – ielādē datus no API un attēlo top spēles
function Homepage({ handleGameSelection }) {
    const [topGames, setTopGames] = useState([]);
    const [isLoading, setIsLoading] = useState(false);
    const [error, setError] = useState(null);

    useEffect(function () {
        async function fetchTopGames() {
            try {
                setIsLoading(true);
                setError(null);

                const response = await fetch("/data/get-top-games");
                if (!response.ok) {
                    throw new Error("Datu ielādes kļūda. Lūdzu, pārlādējiet lapu!");
                }

                const data = await response.json();
                console.log("top games fetched", data);
                setTopGames(data);
            } catch (error) {
                setError(error.message);
            } finally {
                setIsLoading(false);
            }
        }

        fetchTopGames();
    }, []);

    return (
        <>
            {isLoading && <Loader />}
            {error && <ErrorMessage msg={error} />}
            {!isLoading && !error && (
                topGames.map((game, index) => (
                    <TopGameView
                        game={game}
                        key={game.id}
                        index={index}
                        handleGameSelection={handleGameSelection}
                    />
                ))
            )}
        </>
    );
}


// Top spēles skats – attēlo sākumlapas spēles
function TopGameView({ game, index, handleGameSelection }) {
    return (
        <div className="bg-neutral-100 rounded-lg mb-8 py-8 flex flex-wrap md:flex-row">
            <div
                className={`order-2 px-12 md:basis-1/2
                ${index % 2 === 1 ? "md:order-1 md:text-right" : ""}`}
            >
                <h2 className="mb-4 text-3xl leading-8 font-light text-neutral-900">
                    {game.name}
                </h2>

                <p className="mb-4 text-xl leading-7 font-light text-neutral-900">
                    {game.description
                        ? game.description.split(" ").slice(0, 16).join(" ") + "..."
                        : ""}
                </p>

                <SeeMoreBtn
                    gameID={game.id}
                    handleGameSelection={handleGameSelection}
                />
            </div>

            <div
                className={`order-1 md:basis-1/2 ${
                    index % 2 === 1 ? "md:order-2" : ""
                }`}
            >
                <img
                    src={game.image}
                    alt={game.name}
                    className="p-1 rounded-md border border-neutral-200 w-2/4 aspect-auto mx-auto"
                />
            </div>
        </div>
    );
}
// Poga 'Rādīt vairāk'
function SeeMoreBtn({gameID, handleGameSelection }) {
	return (
		<button
			className="inline-block rounded-full py-2 px-4 bg-sky-500 hover:bg-sky-400 text-sky-50 cursor-pointer"
			onClick={() => handleGameSelection(gameID)}
			>Rādīt vairāk</button>
	)
}
// Spēles lapa – strukturāla komponente, kas satur izvēlētās spēles lapas daļas
function GamePage({ selectedGameID, handleGameSelection, handleGoingBack }) {
    return (
        <>
            <SelectedGameView
                selectedGameID={selectedGameID}
                handleGoingBack={handleGoingBack}
            />

            <RelatedGameSection
                selectedGameID={selectedGameID}
                handleGameSelection={handleGameSelection}
            />
        </>
    );
}
// Izvēlētās spēles skats – attēlo datus
// Izvēlētās spēles skats – attēlo datus
function SelectedGameView({ selectedGameID, handleGoingBack }) {
    const [selectedGame, setSelectedGame] = useState({});
    const [isLoading, setIsLoading] = useState(false);
    const [error, setError] = useState(null);

    useEffect(function () {
        async function fetchSelectedGame() {
            try {
                setIsLoading(true);
                setError(null);

                const response = await fetch("/data/get-game/" + selectedGameID);
                if (!response.ok) {
                    throw new Error("Datu ielādes kļūda. Lūdzu, pārlādējiet lapu!");
                }

                const data = await response.json();
                console.log("game " + selectedGameID + " fetched", data);
                setSelectedGame(data);
            } catch (error) {
                setError(error.message);
            } finally {
                setIsLoading(false);
            }
        }

        fetchSelectedGame();
    }, [selectedGameID]);

    return (
        <>
            {isLoading && <Loader />}
            {error && <ErrorMessage msg={error} />}

            {!isLoading && !error && (
                <>
                    <div className="rounded-lg flex flex-wrap md:flex-row">
                        <div className="order-2 md:order-1 md:pt-12 md:basis-1/2">
                            <h1 className="text-3xl leading-8 font-light text-neutral-900 mb-2">
                                {selectedGame.name}
                            </h1>

                            <p className="text-xl leading-7 font-light text-neutral-900 mb-2">
                                {selectedGame.studio}
                            </p>

                            <p className="text-xl leading-7 font-light text-neutral-900 mb-4">
                                {selectedGame.description}
                            </p>

                            <dl className="mb-4 md:flex md:flex-wrap md:flex-row">
                                <dt className="font-bold md:basis-1/4">Izdošanas gads</dt>
                                <dd className="mb-2 md:basis-3/4">{selectedGame.year}</dd>

                                <dt className="font-bold md:basis-1/4">Cena</dt>
                                <dd className="mb-2 md:basis-3/4">
                                    &euro; {selectedGame.price}
                                </dd>

                                <dt className="font-bold md:basis-1/4">Žanrs</dt>
                                <dd className="mb-2 md:basis-3/4">{selectedGame.genre}</dd>
                            </dl>
                        </div>

                        <div className="order-1 md:order-2 md:pt-12 md:px-12 md:basis-1/2">
                            <img
                                src={selectedGame.image}
                                alt={selectedGame.name}
                                className="p-1 rounded-md border border-neutral-200 mx-auto"
                            />
                        </div>
                    </div>

                    <div className="mb-12 flex flex-wrap">
                        <GoBackBtn handleGoingBack={handleGoingBack} />
                    </div>
                </>
            )}
        </>
    );
}

// Poga “Uz sākumu”
function GoBackBtn({ handleGoingBack }) {
    return (
        <button
            className="inline-block rounded-full py-2 px-4 bg-neutral-500 hover:bg-neutral-400 text-neutral-50 cursor-pointer"
            onClick={handleGoingBack}
        >
            Uz sākumu
        </button>
    );
}
// Līdzīgo spēļu sadaļa – ielādē datus no API un attēlo related spēles
function RelatedGameSection({ selectedGameID, handleGameSelection }) {
    const [relatedGames, setRelatedGames] = useState([]);
    const [isLoading, setIsLoading] = useState(false);
    const [error, setError] = useState(null);

    useEffect(function () {
        async function fetchRelatedGames() {
            try {
                setIsLoading(true);
                setError(null);

                const response = await fetch("/data/get-related-games/" + selectedGameID);
                if (!response.ok) {
                    throw new Error("Datu ielādes kļūda. Lūdzu, pārlādējiet lapu!");
                }

                const data = await response.json();
                console.log("related games for " + selectedGameID + " fetched", data);
                setRelatedGames(data);
            } catch (error) {
                setError(error.message);
            } finally {
                setIsLoading(false);
            }
        }

        fetchRelatedGames();
    }, [selectedGameID]);

    return (
        <>
            <div className="flex flex-wrap">
                <h2 className="text-3xl leading-8 font-light text-neutral-900 mb-4">
                    Līdzīgas spēles
                </h2>
            </div>

            {isLoading && <Loader />}
            {error && <ErrorMessage msg={error} />}

            {!isLoading && !error && (
                <div className="flex flex-wrap md:flex-row md:space-x-4 md:flex-nowrap">
                    {relatedGames.map((game) => (
                        <RelatedGameView
                            game={game}
                            key={game.id}
                            handleGameSelection={handleGameSelection}
                        />
                    ))}
                </div>
            )}
        </>
    );
}


// Līdzīgās spēles skats
function RelatedGameView({ game, handleGameSelection }) {
    return (
        <div className="rounded-lg mb-4 md:basis-1/3">
            <img
                src={game.image}
                alt={game.name}
                className="md:h-[400px] md:mx-auto max-md:w-2/4 max-md:mx-auto"
            />

            <div className="p-4">
                <h3 className="text-xl leading-7 font-light text-neutral-900 mb-4">
                    {game.name}
                </h3>

                <SeeMoreBtn
                    gameID={game.id}
                    handleGameSelection={handleGameSelection}
                />
            </div>
        </div>
    );
}
// Ielādes indikators un kļūdas
function Loader() {
    return (
        <div className="my-12 px-2 md:container md:mx-auto text-center clear-both">
            <div className="loader"></div>
        </div>
    );
}







