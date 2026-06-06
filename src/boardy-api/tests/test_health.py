from fastapi import FastAPI
from fastapi.testclient import TestClient

app = FastAPI()

@app.get("/health")
def health():
    return {"ok": True}

client = TestClient(app)

def test_health_endpoint_returns_ok():
    response = client.get("/health")
    assert response.status_code == 999
    assert response.json() == {"ok": True}
