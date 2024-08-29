import {
  Container,
  Box,
  Typography,
  TextField,
  Button,
  CssBaseline,
  Paper,
} from '@mui/material'
import { createTheme, ThemeProvider } from '@mui/material/styles'
import { useRouter } from 'next/router'
import React from 'react'
import { ky } from '@/libs/ky'

const theme = createTheme()

export default function LoginForm() {
  const router = useRouter()

  const handleSubmit = (event: React.FormEvent<HTMLFormElement>) => {
    event.preventDefault()
    const data = new FormData(event.currentTarget)

    ky.post('./api/signup', {
      json: {
        name: data.get('name'),
        email: data.get('email'),
        age: data.get('age'),
        job: data.get('job'),
        prefecture: data.get('address'),
      },
    })
      .then(() => {
        router.push('/signup/verify').then()
      })
      .catch(async (reason) => {
        const error = (await reason.response.json()) as {
          status: string
          type: string
          message: string
          data: { [key: string]: string[] }
        }
        const message = Object.keys(error.data)
          .map((key) => {
            return error.data[key].join(' ')
          })
          .join('\n')
        alert(error.message + '\n\n' + message)
      })
  }

  return (
    <ThemeProvider theme={theme}>
      <Container component="main" maxWidth="xs">
        <CssBaseline />
        <Paper
          elevation={3}
          sx={{
            marginTop: 8,
            padding: 4,
            display: 'flex',
            flexDirection: 'column',
            alignItems: 'center',
          }}
        >
          <Typography component="h1" variant="h5">
            ようこそ
          </Typography>
          <Box
            component="form"
            onSubmit={handleSubmit}
            noValidate
            sx={{ mt: 1 }}
          >
            <TextField
              margin="normal"
              required
              fullWidth
              id="name"
              label="名前"
              name="name"
              autoComplete="name"
              autoFocus
            />
            <TextField
              margin="normal"
              required
              fullWidth
              id="email"
              label="メールアドレス"
              name="email"
              autoComplete="email"
            />
            <TextField
              margin="normal"
              required
              fullWidth
              id="age"
              label="年齢"
              name="age"
              type="number"
            />
            <TextField
              margin="normal"
              required
              fullWidth
              id="job"
              label="仕事"
              name="job"
            />
            <TextField
              margin="normal"
              required
              fullWidth
              id="address"
              label="住所(都道府県)"
              name="address"
            />
            <Button
              type="submit"
              fullWidth
              variant="contained"
              sx={{ mt: 3, mb: 2 }}
            >
              登録
            </Button>
          </Box>
        </Paper>
      </Container>
    </ThemeProvider>
  )
}
