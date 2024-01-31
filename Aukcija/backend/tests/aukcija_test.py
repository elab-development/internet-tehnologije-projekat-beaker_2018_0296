import algokit_utils
import pytest
from algokit_utils import get_localnet_default_account
from algokit_utils.config import config
from algosdk.v2client.algod import AlgodClient
from algosdk.v2client.indexer import IndexerClient

from smart_contracts.artifacts.aukcija.client import AukcijaClient


@pytest.fixture(scope="session")
def aukcija_client(
    algod_client: AlgodClient, indexer_client: IndexerClient
) -> AukcijaClient:
    config.configure(
        debug=True,
        # trace_all=True,
    )

    client = AukcijaClient(
        algod_client,
        creator=get_localnet_default_account(algod_client),
        indexer_client=indexer_client,
    )

    client.deploy(
        on_schema_break=algokit_utils.OnSchemaBreak.ReplaceApp,
        on_update=algokit_utils.OnUpdate.UpdateApp,
        allow_delete=True,
        allow_update=True,
    )
    return client


def test_says_hello(aukcija_client: AukcijaClient) -> None:
    result = aukcija_client.hello(name="World")

    assert result.return_value == "Hello, World"


def test_simulate_says_hello_with_correct_budget_consumed(
    aukcija_client: AukcijaClient, algod_client: AlgodClient
) -> None:
    result = (
        aukcija_client.compose().hello(name="World").hello(name="Jane").simulate()
    )

    assert result.abi_results[0].return_value == "Hello, World"
    assert result.abi_results[1].return_value == "Hello, Jane"
    assert result.simulate_response["txn-groups"][0]["app-budget-consumed"] < 100
